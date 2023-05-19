<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-u1OknCvxWvY5kfmNBILK2hRnQC3Pr17a+RTT6rIHI7NnikvbZlHgTPOOmMi466C8" crossorigin="anonymous">
    </script>
    <script src="https://code.jquery.com/jquery-3.7.0.js" integrity="sha256-JlqSTELeR4TLqP0OG9dxM7yDPqX1ox/HfgiSLBj8+kM=" crossorigin="anonymous"></script>
    <script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"> </script>
    <script>
        $(document).ready(function() {
            $('#myTable').DataTable({
            processing:true,
            serverside:true,
            ajax: "{{ url('programAjax') }}",
            columns:[{
                data:'DT_RowIndex',
                name:'DT_RowIndex',
                orderable: false,
                searchable: false,
            },{
                data:'sumber_dana',
                name:'Sumber dana',
            },{
                data:'program',
                name:'Program',
            },{
                data:'keterangan',
                name:'Keterangan',
            },{
                data: 'aksi',
                name:'Aksi',
            }]
            });
        });

        //PROSES SIMPAN
        $('body').on('click', '.tombol-tambah',function(e){
            e.preventDefault();
            $('#exampleModal').modal('show');
            $('.tombol-simpan').click(function(){
                simpan();
            });
        });

        //PROSES EDIT
        $('body').on('click', '.tombol-edit',function(e){
            var id = $(this).data('id');
            $.ajax({
                url: 'programAjax/' + id + '/edit',
                type: 'GET',
                success: function(response){
                    $('#exampleModal').modal('show');
                    $('#sumber_dana').val(response.result.sumber_dana);
                    $('#program').val(response.result.program);
                    $('#keterangan').val(response.result.keterangan);
                    console.log(response.result);
                    $('.tombol-simpan').click(function() {
                    simpan(id);
                });
                }
            });
        });

        //PROSES DELETE
        $('body').on('click', '.tombol-del',function(e){
            if (confirm('Yakin mau hapus data ini?') == true) {
            var id = $(this).data('id');
            $.ajax({
                url: 'programAjax' + id,
                type: 'DELETE',
            });
            $('#myTable').DataTable().ajax.reload();
        }
        });


        //fungsi simpan dan update
        function simpan(id = ''){
            if (id == '') {
                var var_url = 'programAjax';
                var var_type = 'POST';
            } else {
                var var_url = 'programAjax/' + id;
                var var_type = 'PUT';
            }
            $.ajax({
                    url: var_url,
                    type: var_type,
                    data: {
                        "_token":"{{csrf_token()}}",
                        sumber_dana : $('#sumber_dana').val(),
                        program : $('#program').val(),
                        keterangan : $('#keterangan').val()
                    },
                    success:function(response){
                        if (response.errors){
                            console.log(response.errors);
                            $('.alert-danger').removeClass('d-none');
                            $('.alert-danger').append("<ul>");
                            $.each(response.errors, function(key, value){
                                $('.alert-danger').find('ul').append("<li>" + value + "</li>");
                            });
                            $('.alert-danger').append("</ul>");
                        } else{
                            $('.alert-success').removeClass('d-none');
                            $('.alert-success').html(response.success);
                        }
                        $('#myTable').DataTable().ajax.reload();
                    }
                });
        }

        $('#exampleModal').on('hidden.bs.modal', function(){
            $('#sumber_dana').val('');
            $('#program').val('');
            $('#keterangan').val('');

            $('.alert-danger').addClass('d-none');
            $('.alert-danger').html('');

            $('.alert-success').addClass('d-none');
            $('.alert-success').html('d-none');
        });
    </script>