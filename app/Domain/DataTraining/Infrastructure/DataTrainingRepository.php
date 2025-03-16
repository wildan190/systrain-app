<?php

namespace App\Domain\DataTraining\Infrastructure;

use App\Domain\DataTraining\Model\DataTraining;
use App\Domain\DataTraining\Presentation\Interface\DataTrainingRepositoryInterface;
use Google\Client;
use Google\Service\Drive;

class DataTrainingRepository implements DataTrainingRepositoryInterface
{
  public function createOrUpdate($detailPesertaId, array $data, $request)
  {
    $dataTraining = DataTraining::where('detail_peserta_id', $detailPesertaId)->first();

    // Loop semua field file
    $fields = [
      'detail_peserta_id',
      'upload_pas_foto_biru',
      'upload_ktp',
      'upload_npwp',
      'upload_cv',
      'upload_sk_kerja',
      'upload_keterangan_sehat',
      'upload_pakta_integritas',
      'upload_ijazah',
      'upload_sertifikat_k3',
    ];

    foreach ($fields as $field) {
      if ($request->hasFile($field)) {
        $filename = time() . '_' . $request->file($field)->getClientOriginalName();
        $oldFileId = $dataTraining ? $dataTraining->$field : null;

        $newFileId = $this->uploadFileToGoogleDrive($request->file($field), $filename, $oldFileId);

        $data[$field] = $newFileId;
      }
    }

    return DataTraining::updateOrCreate(
      ['detail_peserta_id' => $detailPesertaId],
      $data
    );
  }

  public function uploadFileToGoogleDrive($file, $filename, $detailPeserta, $oldFileId = null)
  {
    $client = new Client;
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setScopes([Drive::DRIVE_FILE]);
    $client->setAccessType('offline');
    $client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));

    // Simpan token di cache
    $cachedToken = cache('google_access_token');
    if ($cachedToken) {
      $client->setAccessToken($cachedToken);
    }

    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken();
      // Simpan token yang baru di cache
      cache(['google_access_token' => $client->getAccessToken()], now()->addMinutes(60));
    }

    $driveService = new Drive($client);

    // Jika ada file lama, hapus dulu dari Google Drive
    if ($oldFileId) {
      try {
        $driveService->files->delete($oldFileId);
      } catch (\Exception $e) {
        // Log atau tangani error jika file tidak ditemukan
      }
    }

    // Ambil NIK dari detail_peserta
    $nik = $detailPeserta->nomor_induk_kependudukan;

    // Cek apakah folder dengan nama NIK sudah ada
    $folderId = $this->getOrCreateFolder($driveService, $nik, env('GOOGLE_FOLDER_ID'));

    // Buat metadata file
    $fileMetadata = new Drive\DriveFile([
      'name' => $filename,
      'parents' => [$folderId], // Simpan di folder user
    ]);

    $content = file_get_contents($file->getRealPath());

    // Upload file ke Google Drive
    $uploadedFile = $driveService->files->create($fileMetadata, [
      'data' => $content,
      'mimeType' => $file->getMimeType(),
      'uploadType' => 'multipart',
      'fields' => 'id',
    ]);

    return $uploadedFile->id;
  }

  /**
   * Fungsi untuk mendapatkan folder berdasarkan NIK atau membuatnya jika belum ada
   */

  /*private function getOrCreateFolder($driveService, $folderName, $parentFolderId)
    {
        // Cek apakah folder sudah ada
        $query = "name = '$folderName' and mimeType = 'application/vnd.google-apps.folder' and '$parentFolderId' in parents and trashed = false";
        $existingFolders = $driveService->files->listFiles([
            'q' => $query,
            'fields' => 'files(id, name)',
        ]);

        if (count($existingFolders->files) > 0) {
            return $existingFolders->files[0]->id; // Folder sudah ada, pakai ID ini
        }

        // Jika folder tidak ditemukan, buat baru
        $folderMetadata = new Drive\DriveFile([
            'name' => $folderName,
            'mimeType' => 'application/vnd.google-apps.folder',
            'parents' => [$parentFolderId], // Simpan di folder utama
        ]);

        $folder = $driveService->files->create($folderMetadata, [
            'fields' => 'id',
        ]);

        return $folder->id; // Return ID folder yang baru dibuat
    }*/

  /**
   * Fungsi untuk mendapatkan folder berdasarkan NIK atau membuatnya jika belum ada
   */
  private function getOrCreateFolder($driveService, $nik, $parentFolderId)
  {
    // Format nama folder: Training_NIK
    $folderName = "Training_" . $nik;

    // Cek apakah folder sudah ada
    $query = "name = '$folderName' and mimeType = 'application/vnd.google-apps.folder' and '$parentFolderId' in parents and trashed = false";
    $existingFolders = $driveService->files->listFiles([
      'q' => $query,
      'fields' => 'files(id, name)',
    ]);

    if (count($existingFolders->files) > 0) {
      return $existingFolders->files[0]->id; // Folder sudah ada, pakai ID ini
    }

    // Jika folder tidak ditemukan, buat baru
    $folderMetadata = new Drive\DriveFile([
      'name' => $folderName,
      'mimeType' => 'application/vnd.google-apps.folder',
      'parents' => [$parentFolderId], // Simpan di folder utama
    ]);

    $folder = $driveService->files->create($folderMetadata, [
      'fields' => 'id',
    ]);

    return $folder->id; // Return ID folder yang baru dibuat
  }


  public function getGoogleDriveFileUrl($fileId)
  {
    if (! $fileId) {
      return null;
    }

    $client = new Client;
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setScopes([Drive::DRIVE_FILE]);
    $client->setAccessType('offline');
    $client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));

    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken();
    }

    $driveService = new Drive($client);

    try {
      // Ubah permission file menjadi public
      $permission = new Drive\Permission;
      $permission->setType('anyone');
      $permission->setRole('reader');
      $driveService->permissions->create($fileId, $permission);

      // Kembalikan URL preview
      return "https://drive.google.com/file/d/$fileId/preview";
    } catch (\Exception $e) {
      return null;
    }
  }

  public function deleteFileFromGoogleDrive($fileId)
  {
    $client = new Client;
    $client->setClientId(env('GOOGLE_CLIENT_ID'));
    $client->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
    $client->setScopes([Drive::DRIVE_FILE]);
    $client->setAccessType('offline');
    $client->refreshToken(env('GOOGLE_REFRESH_TOKEN'));

    if ($client->isAccessTokenExpired()) {
      $client->fetchAccessTokenWithRefreshToken();
    }

    $driveService = new Drive($client);

    try {
      $driveService->files->delete($fileId);

      return true;
    } catch (\Exception $e) {
      return false;
    }
  }

  public function delete($id)
  {
    $dataTraining = DataTraining::findOrFail($id);

    // Hapus semua file dari Google Drive jika ada
    $fileFields = [
      'detail_peserta_id',
      'upload_pas_foto_biru',
      'upload_ktp',
      'upload_npwp',
      'upload_cv',
      'upload_sk_kerja',
      'upload_keterangan_sehat',
      'upload_pakta_integritas',
      'upload_ijazah',
      'upload_sertifikat_k3',
    ];

    foreach ($fileFields as $field) {
      if (! empty($dataTraining->$field)) {
        $this->deleteFileFromGoogleDrive($dataTraining->$field);
      }
    }

    // Hapus data dari database
    return $dataTraining->delete();
  }

  public function findByDetailPesertaId($detailPesertaId)
  {
    return DataTraining::where('detail_peserta_id', $detailPesertaId)->first();
  }
}
