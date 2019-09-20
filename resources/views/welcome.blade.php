<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Work Assignment</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="" rel="stylesheet">
        <link href="{{ asset('css/datatable4.min.css') }}" rel="stylesheet">
        <!-- Styles -->
        <style>
            /* html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin-top: 2em;
            } */
        </style>
    </head>
    <body>

            <div class="col-md-12" style="text-align:center;">
                <h1>Work Assignment</h1>
                <hr/>
            </div>
            <div  class="col-md-12">
                <div class="row">
                  <div class="col-md-6">
                    <div class="col-md-12">
                        <form>
                                @csrf
                                <input type="text" name="city" id="city" placeholder="City Name" />
                                <input class="btn-primary" type="button" value="Search" name="sc" id="sc"/>
                        </form>
                    </div>
                    <br>
                    <table id="example" class="table table-striped table-bordered" style="width:100%; margin-top: 2em;">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Country</th>
                                <th>Population</th>
                                <th>Type</th>
                                <th>Locate</th>
                            </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>
                  </div>
                  {{-- <div class="col-md-6" style="" id="map"></div> --}}
                  <div class="col-md-6">
                        <iframe
                            name="myMap"
                            id="myMap"
                            width="600"
                            height="450"
                            frameborder="0" style="border:0"
                            src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBy458TdFkra6QkOkgOzrs4NCi4_DkLA3E
                                &q=place_id:ChIJgY9BjQCzjxIRpcnTltGUKRk" allowfullscreen>
                        </iframe>
                  </div>
                </div>
                <div  class="col-md-12">
                        <hr>
                            <b>Description</b>
                        <hr>
                    <div class="row">
                        <div  class="col-md-6">
                            <p>Provide the city name in the input and click search</p>
                            <p>
                                - The name of the city is taken up to search for entries in geonames api
                                together with default parameters (feature code - PPL, PPLC and PPLX : cities - cities1000 and isNameRequired - true) <br>
                                - The returned result is populated in the table, together with an additional column ( to display the place on the map)
                                - The name (i.e toponymName) together with the country is used to get the place id from google places api, which is then
                                used to render the map. <br>
                                - If the returned city is a captital city, it is highlighed green. <br>

                                - Php/Laravel framework is used with libraries ( yajra datatables, bootstrap4 and GuzzleHttp)
                            </p>
                        </div>
                        <div  class="col-md-6">
                            <p>Resources</p>
                            <a href="http://www.geonames.org/export/geonames-search.html">Geonames search options</a>
                            <br>
                            <a href="https://www.geonames.org/export/codes.html">Geonames feature codes</a>
                            <br>
                            <a href="https://developers.google.com/places/web-service/place-id">Google Place ID</a>
                        </div>
                    </div>
                </div>
            </div>



        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
        <script src='https://kit.fontawesome.com/a076d05399.js'></script>

        <script>
            $(document).ready(function() {
                $('#example').DataTable();

                $('#sc').click(function(){
                    var name = $('#city').val();

                        if(!name){
                            alert('Please provide a name');
                        }else{

                            let url = '{{ route("city.search", ":city") }}';

                            url = url.replace(':city', 'city='+name);

                            table = $('#example').DataTable({
                                    "processing":true,
                                    "serverSide":true,
                                    "searching":true,
                                    "deferRender":true,
                                    "draw":1,
                                    "ajax": url,
                                    "columns":[
                                        {"data": 'toponymName'},
                                        {"data": 'countryName'},
                                        {"data": 'population'},
                                        {"data": 'fcodeName'},
                                        {"defaultContent": "<button>Click  <i class='fas fa-map-marker-alt'></i></button>"}
                                    ],
                                    "select": {
                                        'style':'single'
                                    },
                                    "rowCallback": function( row, data ) {
                                        if ( data.fcodeName.includes('capital') ) {
                                            $('td:eq(0)', row).css( "color","white" );
                                            $('td:eq(0)', row).css( "background-color","rgba(127,191,63,0.6)" );

                                            $('td:eq(1)', row).css( "color","white" );
                                            $('td:eq(1)', row).css( "background-color","rgba(127,191,63,0.6)" );

                                            $('td:eq(2)', row).css( "color","white" );
                                            $('td:eq(2)', row).css( "background-color","rgba(127,191,63,0.6)" );

                                            $('td:eq(3)', row).css( "color","white" );
                                            $('td:eq(3)', row).css( "background-color","rgba(127,191,63,0.6)" );

                                            $('td:eq(4)', row).css( "color","white" );
                                            $('td:eq(4)', row).css( "background-color","rgba(127,191,63,0.6)" );

                                        }

                                    },
                                    "createdRow" : function( row, data, dataIndex ){
                                        // if ( data.population == 0  || !data.toponymName.toLowerCase().includes(name.toLowerCase())) {
                                            // $(row).hide();
                                            // table.rows(row).remove().draw();
                                            // $('td:eq(0)', row).css( "color","red" );
                                            // $('td:eq(0)', row).css( "background-color","rgba(127,191,63,0.6)" );
                                        // }
                                    },
                                    "dom": 'Bfrtip',
                                    "scrollY": "400px",
                                    "scrollCollapse": true,
                                    "paging": false,
                                    "bDestroy":true // destroys the table after rendering (keeps it from reinitializing)

                                });

                                $('#example tbody').on( 'click', 'button', function () {
                                    var data = table.row( $(this).parents('tr') ).data();
                                    fetchPlaceId(data['toponymName'],data['countryName'],data['lat'],data['lng']);
                                    // drawMap(data['lat'],data['lng']);
                                } );


                                table.buttons().container().appendTo( $('.col-sm-6:eq(0)', table.table().container() ) );
                        }
                });

                function fetchPlaceId(toponymName,countryName,lat,lng){
                        let addr = '{{ route("place.id", ":toponymName:countryName") }}';
                        addr = addr.replace(':toponymName', 'toponymName='+toponymName);
                        addr = addr.replace(':countryName', '&countryName='+countryName);
                        // addr = addr.replace(':latitude', '&latitude='+parseFloat(lat));
                        // addr = addr.replace(':longitude', '&longitude='+parseFloat(lng));

                        $.ajax({
                            url: addr,
                            success:function(data) {
                                let source = 'https://www.google.com/maps/embed/v1/place?key=AIzaSyBy458TdFkra6QkOkgOzrs4NCi4_DkLA3E&q=place_id:'+data;
                                document.getElementById('myMap').src = source;
                            }
                        });
                }

                // function drawMap(latitude,longitude){
                //     var latx = parseFloat(latitude);
                //     var lngx = parseFloat(longitude);

                //     var map;
                //         map = new google.maps.Map(document.getElementById('map'), {
                //         center: {lat: latx, lng: lngx},
                //         zoom: 8
                //     });
                // }

            } );

            // function initMap() {
            //             map = new google.maps.Map(document.getElementById('map'), {
            //             center: {lat: 35.4, lng: -96.6},
            //             zoom: 8
            //             });
            // }
        </script>
        {{-- <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBy458TdFkra6QkOkgOzrs4NCi4_DkLA3E&callback=initMap"
        async defer></script> --}}
    </body>
</html>
