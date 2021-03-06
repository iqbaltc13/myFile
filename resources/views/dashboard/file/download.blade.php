@extends('layouts.dashboard_modul')
@section('content')
<div class="uk-flex-center" data-uk-grid>
    <div class="uk-width-3-4@l">
        <div class="uk-card">
            <div class="uk-card-header sc-padding">
                <div class="uk-flex uk-flex-middle">
                    <div>
                        <span data-uk-icon="icon:home;ratio:1.4" class="uk-margin-medium-right"></span>
                    </div>
                    <h3 class="uk-card-title">
                        Download File
                    </h3>
                   
                </div>
               
            </div>
            <div class="uk-card-body" >
               
                @if ($errors->any())
                    @foreach ($errors->all() as $error)
                        <div class="uk-alert-danger" data-uk-alert>
                            <a class="uk-alert-close" data-uk-close></a>
                            {{ $error }}
                        </div>
                    @endforeach
                    
                @endif
                <form method="POST" id="form_advanced_validation" class="form-upload-file" action="{{route('dashboard.file.download',['id' => $data->id] )}}" enctype="multipart/form-data">
                    {!! csrf_field() !!}
                    <div class="sc-padding-small">
      
                        <label class="uk-form-label" for="name">Nama<sup>*</sup></label>
                        <div class="uk-form-controls">
                        <input class="uk-input" value="{{$data->name}}" id="name" name="name" type="text" data-sc-input="outline" readonly>
                        </div>
                        @error('name')
                           
                            <div class="uk-alert-danger" data-uk-alert>
                                <a class="uk-alert-close" data-uk-close></a>
                                    {{ $message }}
                            </div>
                        @enderror
                    </div>
                    
                    
                    <div class="uk-margin-top">
                        <button type="submit" class="sc-button sc-button-primary sc-button-large">Download</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@push('scripts')

<script>

new Vue({
            el: '#vue-form-element',
            data:{
                textAlert: '',
                endOfDiv : '</div>',
                alertFormat:{
                    success :  '<div class="uk-alert-success" data-uk-alert>'+
                                '<a class="uk-alert-close" data-uk-close></a>' ,
                    warning :  '<div class="uk-alert-warning" data-uk-alert>'+
                                '<a class="uk-alert-close" data-uk-close></a>' ,
                    danger  :  '<div class="uk-alert-danger" data-uk-alert>'+
                                '<a class="uk-alert-close" data-uk-close></a>' ,
                    primary :   '<div class="uk-alert-primary" data-uk-alert>'+
                                '<a class="uk-alert-close" data-uk-close></a>' 
                }
               
            },
            watch:{
               
            },
            methods:{
               
                
                

                
            },
            computed:{
               
            },
            mounted() {
                
            
            },
        });
</script>
@endpush
@endsection