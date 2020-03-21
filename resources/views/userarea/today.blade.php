@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">

            @if(session()->has('message'))
                <div class="col-12">
                    <div class="alert alert-success alert-dismissible">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                        {{ session()->get('message') }}

                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
            @endif



            <div class="col-md-8">
                <div class="card">
                    <div class="card-header"><h1>Movies released today</h1></div>

                    <div class="card-body">
                       <div class="row">
                           <div class="col-12">
                               <table id="bootstrap-data-table" class="table table-striped table-bordered">
                                   <thead>
                                   <tr>
                                       <td colspan="6">
                                           {{ $movies->appends(Request::except('page'))->links() }} <span class="pull-right">Movies {{ ($movies->currentpage() - 1) * $movies->perpage() + 1 }} ..  {{ min( $movies->currentpage() * $movies->perpage(), $movies->total() ) }} of {{ $movies->total() }}</span>
                                       </td>
                                   </tr>

                                   <tr class="tableHeader">
                                       <th>#</th>
                                       <th>ID</th>
                                       <th>Oritinal Title</th>
                                       <th>Genre</th>
                                       <th>Primary Release Date</th>
                                       <th style="min-width:150px;">Details</th>
                                   </tr>
                                   </thead>
                                   <tbody>

                                   @if (count($movies))

                                       @foreach ($movies as $movie)

                                           <tr>
                                               <td>{{ ($movies->currentpage() - 1) * $movies->perpage() + $loop->index + 1 }}</td>
                                               <td>{{ $movie->tmdb_id }}</td>
                                               <td id="title_{{ $movie->tmdb_id }}">{{ $movie->original_title }}</td>
                                               <td>{{ $movie->genre }}</td>
                                               <td>{{ $movie->primary_release_date }}</td>
                                               <td><span onclick="actionView('{{ $movie->tmdb_id }}')" class="btn btn-block btn-success btn-sm"><span class="fa fa-search"></span> View</span></td>
                                           </tr>

                                       @endforeach
                                       <tr>
                                           <td colspan="6">
                                               {{ $movies->appends(Request::except('page'))->links() }} <span class="pull-right">Movies {{ ($movies->currentpage() - 1) * $movies->perpage() + 1 }} ..  {{ min( $movies->currentpage() * $movies->perpage(), $movies->total() ) }} of {{ $movies->total() }}</span>
                                           </td>
                                       </tr>
                                   @else

                                       <tr>
                                           <td colspan="6">For the moment there are no movies in the database.</td>
                                       </tr>

                                   @endif

                                   </tbody>
                               </table>
                           </div>
                       </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('bottomJs')

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel">Modal title</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div id="myModalBody"></div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        function actionView(movie_id) {
                var title = jQuery('#title_' + movie_id).html();
                jQuery('#myModalLabel').html( "Details for movie: <b>" + title + "</b>" );
                jQuery('#myModalBody').html('<div class="text-center"><div class="lds-spinner"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div></div>');
                jQuery('#myModal').modal();

                jQuery.ajax({
                    type: "GET",
                    url: "details/" + movie_id,
                    dataType: "text",
                    async:false
                }).done(function( data ) {
                    jQuery("#myModalBody").html(data);
                });
            }
    </script>

    <style type="text/css">
        /* spinner */
        .lds-spinner{display:inline-block;position:relative;width:64px;height:64px;margin:0 auto;}.lds-spinner div{transform-origin:32px 32px;animation:lds-spinner 1.2s linear infinite}.lds-spinner div:after{content:" ";display:block;position:absolute;top:3px;left:29px;width:5px;height:14px;border-radius:20%;background:#cef}.lds-spinner div:nth-child(1){transform:rotate(0);animation-delay:-1.1s}.lds-spinner div:nth-child(2){transform:rotate(30deg);animation-delay:-1s}.lds-spinner div:nth-child(3){transform:rotate(60deg);animation-delay:-.9s}.lds-spinner div:nth-child(4){transform:rotate(90deg);animation-delay:-.8s}.lds-spinner div:nth-child(5){transform:rotate(120deg);animation-delay:-.7s}.lds-spinner div:nth-child(6){transform:rotate(150deg);animation-delay:-.6s}.lds-spinner div:nth-child(7){transform:rotate(180deg);animation-delay:-.5s}.lds-spinner div:nth-child(8){transform:rotate(210deg);animation-delay:-.4s}.lds-spinner div:nth-child(9){transform:rotate(240deg);animation-delay:-.3s}.lds-spinner div:nth-child(10){transform:rotate(270deg);animation-delay:-.2s}.lds-spinner div:nth-child(11){transform:rotate(300deg);animation-delay:-.1s}.lds-spinner div:nth-child(12){transform:rotate(330deg);animation-delay:0s}@keyframes lds-spinner{0%{opacity:1}100%{opacity:0}}

        table { font-size:12px !Important;}
        .table td, .table th {
            padding: .25rem;
            vertical-align: middle;
        }

        .poster {
            width:100%;
            height:300px;
            background-size:contain;
            background-repeat:no-repeat;
            background-position: center center;
        }

    </style>

@endsection
