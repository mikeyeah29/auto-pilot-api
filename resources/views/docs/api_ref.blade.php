@extends('layouts.docs')

@section('side_bar')

	<div class="side_bar">

        @foreach($features as $feature)

            <p class="hdln-3">{{ $feature['label'] }}</p>  

            <ul class="no_bullet">
                <?php foreach ($feature['routes'] as $route) { ?>

                    <li>
                        <a href="#section-{{ $route['name'] }}">{{ $route['label'] }}</a>
                    </li>

                <?php } ?>  
            </ul>

        @endforeach

    </div>

@endsection

@section('content')

<div class="row d-flex justify-content-center">
    <div class="col-sm-9 col-lg-8">

        <h1 class="pt-4 pb-5" style="font-size: 36px;">MoonFly API Reference</h1>

        @foreach($features as $feature)

            <div class="section" id="section-{{ $feature['name'] }}">

                <p class="hdln-1">{{ $feature['label'] }}</p>

                <p>{{ $feature['description'] }}</p>

                @foreach($feature['routes'] as $route)

                    <div class="sub-section" id="section-{{ $route['name'] }}">
                        <p class="hdln-2">{{ $route['label'] }}</p>
                        <p>{{ $route['description'] }}</p>
                    </div>

                    <table class="table">
                        <tr>
                            <th>Route</th>
                            <td>{{ $route['path'] }}</td>
                        </tr>
                        <tr>
                            <th>Request Type</th>
                            <td>{{ $route['method'] }}</td>
                        </tr>
                        <tr>
                            <th>Expected Status</th>
                            <td>{{ $route['status_expected'] }}</td>
                        </tr>
                        <tr>
                            <th>Payload</th>
                            <td>
                                
                                <table class="table-simple">

                                    @foreach($route['payload'] as $key => $item)

                                        <tr>
                                            <td class="txt-1">{{ $key }}</td>
                                            <td class="txt-2">{{ $item }}</td>
                                        </tr>
                                    
                                    @endforeach

                                </table>
                                
                            </td>
                        </tr>
                        <tr>
                            <th>Returns</th>
                            <td>

                                <table class="table-simple">

                                    @foreach($route['returns'] as $key => $item)
                                    
                                        <tr>
                                            <td class="txt-1">{{ $key }}</td>
                                            <td class="txt-2">{{ $item }}</td>
                                        </tr>

                                    @endforeach

                                </table>

                            </td>
                        </tr>
                    </table>

                @endforeach

            </div>

        @endforeach

    </div>
</div>

@endsection