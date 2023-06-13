<div class="modal fade" id="modal-department-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Jurusan</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-department-edit" method="POST" class="px-3">
                @method('put')
                @csrf

                <div class="form-group invisible">
                    <input type="hidden" class="form-control" id="department-id" readonly>
                </div>
                <div class="form-group">
                    <label>Nama Jurusan</label>
                    <input type="text" class="form-control" placeholder="Nama Jurusan yang ingin diubah" name="name" id="department-name">
                  </div>
                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="editDepartment()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="modal-class-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Ubah Data Kelas</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="#" id="form-class-edit" method="POST" class="px-3">
                @method('put')
                @csrf

                <div class="form-group invisible">
                    <input type="hidden" class="form-control" id="class-id" readonly>
                </div>

                <div class="form-group">
                    <label>Tingkatan</label>
                    <select class="custom-select" name="grade" id="grade-dropdown">
                        <option value="10">10</option>
                        <option value="11">11</option>
                        <option value="12">12</option>
                    </select>
                </div>

                <div class="form-group">
                    <label>Jurusan</label>
                    <select class="custom-select" name="department_id" id="department-dropdown">
                    </select>
                </div>

                <div class="modal-footer align-right mt-2 pt-2">
                  <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-chevron-left mr-1"></i> Batal</a>
                  <button type="submit" class="btn btn-primary" onclick="editClass()"><i class="fa fa-save fa-sm mr-1"></i> Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>