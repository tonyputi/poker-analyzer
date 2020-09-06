@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Analyzer</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif                    

                    <form class="form mb-2" method="POST" action="{{ route('analyze') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-md-10 mb-2">
                                <div class="custom-file is-invalid">
                                    <input id="file" type="file" name="file" class="custom-file-input {{ $errors->has('file') ? 'is-invalid' : '' }}" />
                                    <label class="custom-file-label" for="file">Choose file</label>
                                </div>                                
                                @error('file')
                                <small class="form-text text-danger">{{ $errors->first('file') }}</small>
                                @enderror
                            </div>
                            <div class="col-12 col-md-2 mb-2">
                                <button type="submit" class="btn btn-primary btn-block" type="button">Analyze</button>
                            </div>
                        </div>
                    </form>

                    @if($hands->count())

                    <div class="card-deck mb-3">
                        <div class="card">
                            <div class="card-body text-center">
                                <span style="font-size: 48px; color: Dodgerblue;">
                                    <i class="fas fa-user"></i>
                                </span>    
                                <h4 class="card-title">Player 1</h4>
                                <h5>Win: {{ $players[0]->wins }} times</h5>                                
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body text-center">
                                <span style="font-size: 48px; color: Tomato;">
                                    <i class="fas fa-user"></i>
                                </span>    
                                <h4 class="card-title">Player 2</h4>
                                <h5>Win: {{ $players[1]->wins }} times</h5>                                
                            </div>
                        </div>
                    </div>

                    <table class="table table-striped table-hover">
                        <thead class="thead-light">
                            <tr>
                                <th>#</th>
                                <th>Player 1 Cards</th>
                                <th>Player 1 Rank</th>
                                <th>Player 2 Cards</th>
                                <th>Player 2 Rank</th>
                                <th>Winner</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($hands as $hand)
                            <tr>
                                <th class="align-middle" scope="row">{{ $hand->id }}</th>                                
                                <td>
                                    @foreach($hand->p1_cards_images as $image)
                                    <img src="{{ asset("images/cards/$image") }}" height="64" />
                                    @endforeach
                                </td>
                                <td class="align-middle">{{ $hand->p1_rank }}</td>                                
                                <td>
                                    @foreach($hand->p2_cards_images as $image)
                                    <img src="{{ asset("images/cards/$image") }}" height="64" />
                                    @endforeach
                                </td>
                                <td class="align-middle">{{ $hand->p2_rank }}</td>
                                <td class="align-middle">{{ $hand->winner }}</td>
                            </tr>
                        @endforeach        
                        </tbody>
                    </table>
                    {{ $hands->links() }}
                    @else
                    <div class="alert alert-primary" role="alert">
                        <strong>Ooops!</strong> No hands found! Upload hands by txt file
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
