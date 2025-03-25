<?php

namespace App\Domain\Program\Presentation;

use App\Domain\DetailPeserta\Model\DetailPeserta;
use App\Domain\Program\Action\CreateProgram;
use App\Domain\Program\Action\DestroyProgram;
use App\Domain\Program\Action\UpdateProgram;
use App\Domain\Program\Infrastructure\ProgramRepository;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Domain\Program\Model\DetailProgram;

class ProgramController extends Controller
{
  protected $programRepository;

  public function __construct(ProgramRepository $programRepository)
  {
    $this->programRepository = $programRepository;
  }

  public function index(Request $request)
  {
    $search = $request->input('search');
    $programs = $this->programRepository->getAll(10, $search);

    return view('pages.admin.program.index', compact('programs', 'search'));
  }

  public function create()
  {
    return view('pages.admin.program.create');
  }

  public function store(Request $request)
  {
    $data = $request->validate([
      'nama_program' => 'required|string',
      'batch' => 'required|integer',
      'peserta' => 'required|integer|min:0',
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
      'harga' => 'required|numeric|min:0',
    ]);

    CreateProgram::handle($data);

    return redirect()->route('program.index')->with('success', 'Program berhasil ditambahkan');
  }

  public function edit($id)
  {
    $program = $this->programRepository->findById($id);

    return view('pages.admin.program.edit', compact('program'));
  }

  public function update(Request $request, $id)
  {
    $data = $request->validate([
      'nama_program' => 'required|string',
      'batch' => 'required|integer',
      'peserta' => 'required|integer|min:0',
      'tanggal_mulai' => 'required|date',
      'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
      'harga' => 'required|numeric|min:0',
    ]);

    $program = $this->programRepository->findById($id);
    UpdateProgram::handle($program, $data);

    return redirect()->route('program.index')->with('success', 'Program berhasil diperbarui');
  }

  public function show($id)
  {
    $program = $this->programRepository->findById($id);
    $pesertas = $program->detailPrograms()->with('detailPeserta')->get();
    return view('pages.admin.program.show', compact('program', 'pesertas'));
  }


  public function destroy($id)
  {
    $program = $this->programRepository->findById($id);
    DestroyProgram::handle($program);

    return redirect()->route('program.index')->with('success', 'Program berhasil dihapus');
  }

  public function addParticipants($id)
{
    $program = $this->programRepository->findById($id);
    $pesertas = DetailPeserta::all();
    return view('pages.admin.program.add_participants', compact('program', 'pesertas'));
}

public function storeParticipants(Request $request, $id)
{
    $request->validate([
        'detail_peserta_id.*' => 'required|exists:detail_pesertas,id',
    ]);

    $program = $this->programRepository->findById($id);

    foreach ($request->detail_peserta_id as $pesertaId) {
        $nomorPeserta = 'P-' . str_pad(DetailProgram::max('id') + 1, 5, '0', STR_PAD_LEFT);

        DetailProgram::create([
            'program_id' => $program->id,
            'nomor_peserta' => $nomorPeserta,
            'detail_peserta_id' => $pesertaId,
        ]);
    }

    return redirect()->route('program.show', $id)->with('success', 'Peserta berhasil ditambahkan!');
}

public function removeParticipant($id)
{
    $peserta = DetailProgram::findOrFail($id);
    $peserta->delete();

    return redirect()->back()->with('success', 'Peserta berhasil dihapus!');
}

}
