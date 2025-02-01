@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">{{ $pageTitle }}</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div id="medicines_table_wrapper" class="dataTables_wrapper dt-bootstrap4">
                        <div class="row">
                            <div class="col-sm-12">
                                @if (session()->has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="fa-solid fa-check mr-1"></i>
                                        {!! session('success') !!}
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <table id="medicines_table" class="table table-bordered table-striped dataTable dtr-inline"
                                    aria-describedby="medicines_table_info">
                                    <thead>
                                        <tr>
                                            <th style="width: 10px">#</th>
                                            <th>Nama Obat</th>
                                            <th>Harga Saat Ini</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($medicines as $medicine)
                                            <tr class="odd">
                                                <td>{{ $loop->iteration }}.</td>
                                                <td>{{ $medicine['name'] }}</td>
                                                <td>Rp {{ number_format($medicine['harga'], 0, '', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
            </div>
        </div>
    </div>

@section('custom_script')
    <script>
        @if (count($errors) > 0)
            $('#addModal').modal('show');
        @endif

        $(function() {
            $("#medicines_table").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "ordering": false,
                "buttons": [
                    "print",
                    {
                        extend: 'pdfHtml5',
                        exportOptions: {
                            columns: [0, 1, 2]
                        }
                    },
                    "colvis"
                ]
            }).buttons().container().appendTo('#medicines_table_wrapper .col-md-6:eq(0)');
            // $('#example2').DataTable({
            //     "paging": true,
            //     "lengthChange": false,
            //     "searching": false,
            //     "ordering": true,
            //     "info": true,
            //     "autoWidth": false,
            //     "responsive": true,
            // });
        });
    </script>
@endsection
@endsection
