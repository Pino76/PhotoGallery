@extends('templates.default')
@section('content')

    @if(session()->has('message'))
        <x-alert-info>{{session()->get('message')}}</x-alert-info>
    @endif
    <div class="row">
        <div class="col-sm-9">
            <h3>Category List</h3>
            <table class="table table-striped table-dark" id="categoryList">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Created</th>
                        <th>Updated</th>
                        <th>Albums</th>
                        <th>-</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories AS $cat)
                    <tr id="tr-{{$cat->id}}">
                        <td>{{$cat->id}}</td>
                        <td id="catId-{{$cat->id}}">{{$cat->category_name}}</td>
                        <td>{{$cat->created_at->format('Y-m-d')}}</td>
                        <td>{{$cat->updated_at->format('Y-m-d')}}</td>
                        <td>
                            @if($cat->albums_count > 0)
                                <a class="btn btn-success" href="{{route('albums.index')}}?category_id={{$cat->id}}">{{$cat->albums_count}}</a>
                            @else
                                {{$cat->albums_count}}
                            @endif
                        </td>
                        <td class="d-flex justify-content-center">
                            <a href="{{route('categories.edit' , $cat->id)}}" id="upd-{{$cat->id}}" title="modifica" class="btn btn-outline-info m-1"><i class="bi bi-pen"></i></a>
                            <form action="{{route('categories.destroy', $cat->id)}}" method="post">
                                @csrf
                                @method("delete")
                                <button class="btn btn-danger m-1" id="btnDelete-{{$cat->id}}" title="cancella"><i class="bi bi-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            No categories
                        </td>
                    </tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="6">{{$categories->links('vendor.pagination.bootstrap-4')}}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
        <div class="col-sm-3">
            @include('categories.categoryform')
        </div>
    </div>
@endsection

@section('footer')
    @parent
    <script>
        $(function(){
            const categoryUrl = '{{ route('categories.store') }}';
            $('div.alert').fadeOut(5000);
            $("form .btn-danger").on("click", function(evt){
                evt.preventDefault();

                let f = this.parentNode;
                var categoryId = this.id.replace("btnDelete-", "");
                var trId = "tr-"+categoryId;
                let urlCategory = f.action;

                $.ajax(urlCategory,
                    {
                    method: "DELETE",
                    data:{
                        '_token' : Laravel.csrf_token
                    },
                    complete:function (resp){

                        let response = JSON.parse(resp.responseText);

                        if(response.success){
                            $("#"+trId).fadeOut();
                        }else {
                            alert('Problem contacting server');
                        }
                    }
                })

            });
            // End Delete

            //Insert
            $("#manageCategoryForm .btn-primary").on("click", function(evt){
                evt.preventDefault();

                let f = $("#manageCategoryForm");
                let data = f.serialize();
                let urlCategory = f.attr('action');

                $.ajax(urlCategory,
                    {
                        method: "POST",
                        data: data,

                    }).done(response=>{
                        $('#methodType').remove();
                        selectedCategory = null;
                        f[0].action = categoryUrl;
                        alert(response.message);
                        if(response.success){
                            f[0].category_name.value = '';
                            f[0].reset();
                        } else {
                            alert('Problem contacting server');
                        }
                })
            });
            //End Insert
            const f = $('#manageCategoryForm');
            let selectedCategory = null;
            f[0].category_name.addEventListener('keyup', function(){
                if(selectedCategory){
                    selectedCategory.text( f[0].category_name.value);
                }
            });
            //Update
            $("#categoryList a.btn-outline-info").on("click",  function(evt){
                evt.preventDefault();

                let categoryId = this.id.replace('upd-', '')*1;
                let catRow = $("#tr-"+categoryId);
                $("#categoryList tr").css('border','0px');
                catRow.css('border','1px solid #F00');
                let urlUpdate = this.href.replace('/edit', '');

                let tdCat = $("#catId-" + categoryId);
                selectedCategory = tdCat;
                let category_name = tdCat.text();
                let f = $("#manageCategoryForm");
                f.attr("action", urlUpdate)
                f[0].category_name.value = category_name;
                const inputT = document.querySelector('#methodType');

                if(!inputT) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = '_method';
                    input.value = 'PATCH';
                    f[0].appendChild(input);
                }

            });
            //End Update

        });
    </script>
@endsection
