@extends('layouts.dashboard_modul')
@section('title')
    File
@endsection
@section('content')
<div class="uk-card uk-margin" id="vue_component">
    
    <div class="uk-flex-middle sc-padding sc-padding-medium-ends uk-grid-small" data-uk-grid>
        <div class="uk-flex-1 uk-first-column">
            <h3 class="uk-card-title">&nbsp;&nbsp;&nbsp;History Upload File </h3>
        </div>
        <div class="uk-width-auto@s">
            <div id="sc-dt-buttons">
                <div class="dt-buttons">
                   
                   
                </div>
                
            </div>
        </div>
        
    </div>
    <div id="alert-elements" >
        @if(Session::get('success'))
         
        <div class="uk-alert-success" data-uk-alert>
            <a class="uk-alert-close" data-uk-close></a>
              {{Session::get('success')}}
        </div>
          

        @endif
    </div>
    <hr class="uk-margin-remove">
    <div class="uk-card-body">
        <div data-uk-grid="" class="uk-grid">
            
            
        </div>
      
        <table width="100%" id="sc-dt-buttons-table" class="uk-table uk-table-striped dt-responsive datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama File</th>
                    
                   
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
               
                
            </tbody>                
        </table>
       
        
        
       
    </div>
</div>
@push('scripts')

<script>
    let refresh = setInterval(function () { 
        datatableReloadAll(); 
        alertSuccess('Sukses memuat data');
    }, 60000);
    function alertSuccess(message) {
        
        let alert = '<div class="uk-alert-success uk-alert" data-uk-alert="">'+
                        '<a class="uk-alert-close uk-icon uk-close" data-uk-close="">'+
                            '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon">'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>'+
                            '</svg>'+
                        '</a>'+message+					
                    '</div>';
                    
        document.querySelector('#alert-elements').innerHTML=alert;
        //$('#alert-elements').append(alert);
    }
   
    function datatableWithParse(arrParse,message){
        var url = "{{route('dashboard.file.datatable')}}";
        url = url + '?';
        for (var key in arrParse) {
            if (arrParse.hasOwnProperty(key)){
                url=url+key+'='+arrParse[key]+'&&';
                
            }
               
        }
        
        //$('.datatable tbody').empty();
       
        let table =$('.datatable').DataTable().ajax.url(url).load();
        

        let alert = '<div class="uk-alert-success uk-alert" data-uk-alert="">'+
                        '<a class="uk-alert-close uk-icon uk-close" data-uk-close="">'+
                            '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon">'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>'+
                            '</svg>'+
                        '</a>'+message+					
                    '</div>';

        document.querySelector('#alert-elements').innerHTML=alert;


        return table;
        
    }
    
    function datatableReloadAfterAction(message){
        
        let table =$('.datatable').DataTable().ajax.reload();
        let alert = '<div class="uk-alert-success uk-alert" data-uk-alert="">'+
                        '<a class="uk-alert-close uk-icon uk-close" data-uk-close="">'+
                            '<svg width="14" height="14" viewBox="0 0 14 14" xmlns="http://www.w3.org/2000/svg" data-svg="close-icon">'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="1" y1="1" x2="13" y2="13"></line>'+
                                '<line fill="none" stroke="#000" stroke-width="1.1" x1="13" y1="1" x2="1" y2="13"></line>'+
                            '</svg>'+
                        '</a>'+message+					
                    '</div>';

        document.querySelector('#alert-elements').innerHTML=alert;
       
        return table;
        
    }
    function datatableReloadAll(){
        var url = "{{route('dashboard.file.datatable')}}";
        let table =$('.datatable').DataTable().ajax.url(url).load();
       
        return table;
        
    }
    function datatable(){
        var url = "{{route('dashboard.file.datatable')}}";
        var table = $('.datatable').DataTable({
            "autoWidth": true,
            "scrollX"         :       true,
            "scrollCollapse"  :       true,
            // ordering: false,
            "columnDefs": [
                            
                            
                            
                            
                            
                            {
                                    "targets": '_all',
                                    "defaultContent": "---"
                            },
                        ],
            "order": [[ 0, "desc" ]],
           
            "processing": true,
            //"serverSide": true,
            "ordering": false,
            
            "ajax": url,
            "columns": [
                    { 
                        data: 'id',
                    },
                   
                    {
                        data: 'name',
                        

                    },
                   
                   
                   
                    { 
                        data: null,
                        searchable: false,
                        render: function(data){
                            let linkDownload = "";
                              
                            let aksi='';
                            aksi += '<div><a class="sc-button sc-button-primary sc-js-button-wave-light" href="'+linkDownload+'"><span data-uk-icon="icon: pencil"></span></span> Download</a></div>';

                                       

                                                     
                                
                            return aksi;
                        }
                        
                    },
                    
                    
                    
                ]
        });

        return table;
    }
   
</script>

<script>
    var base_path = "{{asset("")}}";
    new Vue({
            el: '#vue_component',
            data:{
                selectIsAdaGambar: "all",
            },
            watch:{
               
            },
            methods:{
                
                
                
               
                
            },
            computed:{
               
            },
            mounted() {
                datatable(); 
            },
        });

</script>

@endpush
@endsection