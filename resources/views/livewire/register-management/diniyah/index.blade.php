<div>
    <div class="row g-2">
        <div class="col-6 col-sm-3 mb-5">
            <input type="text" wire:model.live.debounce="search" placeholder="Masukkan nama/ID/NIK..." class="form-control form-control-sm">
        </div>
        <div class="col-4 col-sm-2">
            <select wire:model.live="institution" class="form-control form-control-sm">
                <option value="">.:Semua Tingkat:.</option>
                @foreach($institutions as $institution)
                    <option value="{{ $institution->id }}">{{ $institution->shortname }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-2 col-sm-2 mb-5">
            <select wire:model.live="status" class="form-control form-control-sm">
                <option value="">.:Semua Status:.</option>
                <option value="1">Baru</option>
                <option value="0">Lama</option>
            </select>
        </div>
    </div>
    <div class="col-12 mb-5 mb-xl-10" wire:loading.delay>
        <div class="card">
            <div class="card-body">
                <div>
                    <div class="d-flex align-items-center text-muted">
                        <span>Data sedang dimuat...</span>
                        <div class="spinner-border ms-auto" role="status" aria-hidden="true"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 mb-5 mb-xl-10" wire:loading.remove>
        <div class="card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-rounded table-row-bordered gy-5 gs-7 mb-0">
                        <thead>
                        <tr class="fw-bold fs-6 text-gray-800">
                            <th>ID</th>
                            <th>NIK</th>
                            <th>NAMA</th>
                            <th>KELAS</th>
                            <th>TINGKAT</th>
                            <th>STATUS</th>
                            <th class="text-center">OPSI</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($diniyahs as $diniyah)
                            <tr wire:key="{{ $diniyah->id }}">
                                <td>{{ $diniyah->id }}</td>
                                <td>{{ \Illuminate\Support\Str::mask($diniyah->student?->nik, '*', -12, 10) }}</td>
                                <td>{{ $diniyah->student?->name }}</td>
                                <td>{{ $diniyah->grade_of_diniyah }}</td>
                                <td>{{ $diniyah->diniyah->shortname }}</td>
                                <td class="text-center">
                                    @if($diniyah->is_new_diniyah)
                                        <span class="badge badge-light-primary">Baru</span>
                                    @else
                                        <span class="badge badge-light-danger">Lama</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <button title="Detail data" class="btn btn-icon btn-active-light-primary w-30px h-30px" onclick="showDomicile('{{ $diniyah->id }}')">
                                        {!! getIcon('tablet-text-up','fs-3') !!}
                                    </button>
                                    <button title="Detail data" class="btn btn-icon btn-active-light-primary w-30px h-30px" onclick="addRegistration('{{ $diniyah->student->id }}')">
                                        {!! getIcon('plus-square','fs-3') !!}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-danger">
                                    Tidak ada data untuk ditampilkan
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-5 px-7">
                {{ $diniyahs->links() }}
            </div>
        </div>
    </div>
</div>
