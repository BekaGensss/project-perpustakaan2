@extends('admin.layout.main')
@section('title', 'Master User')
@section('content')
<div class="container-fluid pt-3 pb-4">
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm border-0 mb-4" style="border-radius: 16px; overflow: hidden;">
                
                {{-- Header & Aksi Tambah --}}
                <div class="card-header bg-white border-0 pt-4 pb-3 px-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h4 style="font-weight: 700; color: #0f172a; margin: 0;"><i class="fas fa-users-cog text-primary mr-2"></i> Manajemen Akun</h4>
                        <p class="text-muted mt-1 mb-0" style="font-size: 14px;">Kelola hak akses pengguna, staf, maupun member perpustakaan.</p>
                    </div>
                    <div>
                        <button class="btn btn-primary" onclick="tampilUserModal()" style="background: linear-gradient(135deg, #6366f1, #4f46e5); color: white; border: none; font-weight: 600; padding: 10px 20px; border-radius: 8px; box-shadow: 0 4px 10px rgba(99,102,241,0.3);">
                            <i class="fas fa-user-plus mr-2"></i>Tambah Pengguna
                        </button>
                    </div>
                </div>

                {{-- Tabel Data --}}
                <div class="card-body p-0">
                    <div class="table-responsive px-4 pb-4">
                        <table id="example1" class="table table-hover table-modern mb-0" style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">#</th>
                                    <th>Profil User</th>
                                    <th>Kontak & Lokasi</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Hak Akses</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $item)
                                <tr>
                                    <td class="text-center" style="font-weight: 600; vertical-align: middle;">{{ $loop->iteration }}</td>
                                    
                                    {{-- Kolom Profil dengan Gambar --}}
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex align-items-center">
                                            <div style="width: 45px; height: 45px; border-radius: 50%; overflow: hidden; margin-right: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); flex-shrink: 0;">
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="User" style="width: 100%; height: 100%; object-fit: cover;">
                                            </div>
                                            <div>
                                                <div class="nama-user" style="font-weight: 700; color: #0f172a; font-size: 15px;">{{ $item->nama }}</div>
                                                <div style="font-size: 12px; color: #64748b; margin-top: 2px;">ID: #{{ str_pad($item->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    
                                    {{-- Kontak --}}
                                    <td style="vertical-align: middle;">
                                        <div style="font-size: 13px; color: #0f172a; font-weight: 500;"><i class="fas fa-envelope text-primary mr-2" style="width:14px;"></i>{{ $item->email }}</div>
                                        <div style="font-size: 13px; color: #64748b; margin-top: 4px; overflow: hidden; text-overflow: ellipsis; max-width: 200px; white-space: nowrap;"><i class="fas fa-map-marker-alt text-danger mr-2" style="width:14px;"></i>{{ $item->alamat }}</div>
                                    </td>
                                    
                                    {{-- Status --}}
                                    <td class="text-center" style="vertical-align: middle;">
                                        @if($item->is_active == 1)
                                            <span class="badge" style="background: #d1fae5; color: #065f46; padding: 6px 12px; font-weight: 600;"><i class="fas fa-check-circle mr-1"></i> Aktif</span>
                                        @else
                                            <span class="badge" style="background: #fee2e2; color: #991b1b; padding: 6px 12px; font-weight: 600;"><i class="fas fa-times-circle mr-1"></i> Suspend</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Role --}}
                                    <td class="text-center" style="vertical-align: middle;">
                                        @if($item->role_id == 1)
                                            <span class="badge" style="background: #e0e7ff; color: #4338ca; padding: 6px 16px; font-weight: 700; border: 1px solid #c7d2fe;"><i class="fas fa-user-shield mr-1"></i> Admin</span>
                                        @else
                                            <span class="badge" style="background: #f1f5f9; color: #475569; padding: 6px 16px; font-weight: 600; border: 1px solid #e2e8f0;"><i class="fas fa-user mr-1"></i> Member</span>
                                        @endif
                                    </td>
                                    
                                    {{-- Aksi --}}
                                    <td style="vertical-align: middle;">
                                        <div class="d-flex justify-content-center" style="gap: 5px;">
                                            <button type="button" class="btn btn-sm btn-info text-white" data-toggle="tooltip" title="Lihat Profil" onclick="tampilUserModal('{{ $item->id }}', this)" style="border-radius: 6px;">
                                                <i class="fas fa-eye"></i>
                                            </button>
                                            <button type="button" class="btn btn-sm btn-warning text-dark" data-toggle="tooltip" title="Ubah Data" onclick="tampilUserModal('{{ $item->id }}', this)" style="border-radius: 6px; font-weight:600;">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <form action="{{ route('admin.master.user.resetPassword', $item->id) }}" method="POST" class="d-inline m-0">
                                                @csrf
                                                @method('PUT')
                                                <button type="button" class="btn btn-sm text-white reset-password" data-toggle="tooltip" title="Reset Sandi" style="border-radius: 6px; background-color: #8b5cf6; border-color: #8b5cf6;">
                                                    <i class="fas fa-key"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.master.user.destroy', $item->id) }}" method="POST" class="d-inline m-0">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger hapus-data" data-toggle="tooltip" title="Hapus Akun" style="border-radius: 6px;">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><div class="modal fade" id="userModal" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="userModalLabel">Tambah User Baru</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.master.user.store') }}" method="POST" id="userForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="formMethod" value="POST">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label for="nama">Nama User</label>
                                <input type="hidden" name="id" value="" id="id">
                                <input type="text" class="form-control" id="nama" name="nama" placeholder="Isikan nama user" required>
                            </div>
                            <div class="form-group">
                                <label for="alamat">Alamat</label>
                                <input type="text" class="form-control" id="alamat" name="alamat" placeholder="Isikan alamat" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="Isikan email" required readonly>
                            </div>
                            <div class="form-group d-none" id="status">
                                <label for="status">Status</label>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline pr-4">
                                        <input type="radio" id="aktif" name="status" value="1">
                                        <label for="aktif"> Aktif</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="tidak_aktif" name="status" value="0">
                                        <label for="tidak_aktif"> Tidak Aktif</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role_id">Role</label>
                                <div class="form-group clearfix">
                                    <div class="icheck-primary d-inline pr-4">
                                        <input type="radio" id="role_admin" name="role_id" value="1">
                                        <label for="role_admin"> Administrator</label>
                                    </div>
                                    <div class="icheck-primary d-inline">
                                        <input type="radio" id="role_anggota" name="role_id" value="2">
                                        <label for="role_anggota"> Anggota</label>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="input-gorup">
                                    <label for="image">Gambar</label>
                                    <a href="#" class="d-none" onclick="resetImage()" id="reset"> [ Reset Image ]</a>
                                    <img class="img-preview img-fluid mb-3 col-sm-5 d-block" src="" style="width: 100%;">
                                    <div class="custom-file">
                                        <input type="hidden" name="oldImage" value="" id="oldImage">
                                        <input type="file" class="custom-file-input" id="image" name="image" accept="image/x-png,image/jpg,image/jpeg" onchange="previewImage()">
                                        <label class="custom-file-label" for="image">Pilih file...</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary simpan-ubah">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $("#example1").DataTable({
            responsive: true,
            autoWidth: false,
        });
    });

    $('[data-toggle="tooltip"]').tooltip();

    function tampilUserModal(id = null, element) {
        let $userModal = $('#userModal');
        let $title = $(element).attr("data-original-title");
        let $actionButton = $userModal.find('.simpan-ubah');
        let $form = $('#userForm');
        let $formMethod = $('#formMethod');
        let $status = $('#status');

        $userModal.modal('toggle');

        function setFormData(data, isReadOnly) {
            $('#id').val(data.id || '');
            $('#nama').val(data.nama || '').prop('readonly', isReadOnly);
            $('#alamat').val(data.alamat || '').prop('readonly', isReadOnly);
            $('#email').val(data.email || '').prop('readonly', true); // Tetap readonly di form modal
            $('input[name=status]').prop('disabled', isReadOnly);
            $('input[name=role_id]').prop('disabled', isReadOnly);
            
            // Set radio button Status
            if(data.is_active == '1') {
                $('#aktif').prop('checked', true);
            } else if (data.is_active == '0') {
                $('#tidak_aktif').prop('checked', true);
            } else {
                // Clear selections if data.is_active is null (for create form)
                $('input[name=status]').prop('checked', false);
            }

            // Set radio button Role
            if(data.role_id == '1') {
                $('#role_admin').prop('checked', true);
            } else if (data.role_id == '2') {
                $('#role_anggota').prop('checked', true);
            } else {
                $('input[name=role_id]').prop('checked', false);
            }
            
            $('.img-preview').attr('src', data.image ? (APP_URL + '/storage/' + data.image) : '');
            $('.custom-file-label').text('Pilih file...');
            $('#image').prop('disabled', isReadOnly);
            isReadOnly ? $('.custom-file-label').hide() : $('.custom-file-label').show();
            $('#oldImage').val(data.image);
        }

        if (id == null) {
            $('#userModalLabel').text('Tambah User Baru');
            setFormData({}, false);
            $actionButton.text('Simpan').show();
            $form.attr('action', '{{ route('admin.master.user.store') }}');
            $formMethod.val('POST');
            $status.addClass('d-none');
            $('#email').prop('readonly', false); // Email dapat diisi saat membuat user baru
            $('input[name=status]').prop('disabled', false);
            $('input[name=role_id]').prop('disabled', false);
        } else {
            let isReadOnly = $title == 'Detail';
            $('#userModalLabel').text(isReadOnly ? 'Detail User' : 'Edit User');
            $status.removeClass('d-none');
            
            $.ajax({
                url: '{{ url('/') }}/admin/master/user/' + id,
                dataType: 'json',
                type: 'GET',
                error: function() {
                    toastr.error('Server error occurred', 'Error', {
                        CloseButton: true,
                        ProgressBar: true
                    });
                },
                success: function(data) {
                    setFormData(data, isReadOnly);

                    if (isReadOnly) {
                        $actionButton.hide();
                        $form.attr('action', ''); // No action for detail view
                    } else {
                        $actionButton.text('Ubah').show();
                        $form.attr('action', '{{ url('/') }}/admin/master/user/' + id); // Edit route
                        $formMethod.val('PUT');
                    }
                },
            });
        }
    }

    function previewImage() {
        const image = $('#image');
        const imgPreview = $('.img-preview');
        const file = image[0].files[0];
        const reader = new FileReader();

        reader.onload = function(event) {
            imgPreview.attr('src', event.target.result);
        }

        if (file) {
            reader.readAsDataURL(file);
            $('.custom-file-label').html(file.name);
            $('#reset').removeClass('d-none');
        }
    }

    function resetImage() {
        const imgPreview = $('.img-preview');
        const oldImage = $('#oldImage').val();

        if (oldImage) {
            imgPreview.attr('src', APP_URL + '/storage/' + oldImage);
        } else {
            imgPreview.attr('src', '');
        }

        $('.custom-file-label').html('Pilih file...');
        $('#reset').addClass('d-none');
    }

    $(document).on('click', '.hapus-data', function() {
        var form = $(this).closest("form");
        var nama_user = $(this).closest("tr").find('.nama-user').html();
        if (confirm('Yakin ingin menghapus data user ' + nama_user + '??')) {
            form.submit();
        }
    });

    $(document).on('click', '.reset-password', function() {
        var form = $(this).closest("form");
        var nama_user = $(this).closest("tr").find('.nama-user').html();
        if (confirm('Yakin ingin reset password user ' + nama_user + '??')) {
            form.submit();
        }
    });

    @error('image')
        toastr.error('{{ $message }}');
    @enderror

    @error('email')
        toastr.error('{{ $message }}');
    @enderror
</script>
@endpush