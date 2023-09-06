@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                   <h4>Hello, {{Auth::user()->name}}</h4>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div id="form" style="display:none;">
        <h4>Add Task</h4>
        <form action="" method="post" id="">
            <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Task Title</label>
                <textarea class="form-control" id="tasktitle" rows="3" placeholder="enter task title"></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Add</button>
        </form>
    </div>
    <div class="header">
        <h2 class="text-center">Your tasks</h2>
        <button class="btn btn-primary" onclick="showForm(this)">Add Task</button>
    </div>
    <div class="row justify-content-center">
        <ul class="list-group" id="data">
        </ul>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function(){
        getData();
       
        $('.task-status').on('change',function(){  
            });
        });
        $('#form').submit(function(event){
            event.preventDefault();
            const title=event.target.tasktitle.value;
            const user_id={{Auth::user()->id}}
            $.ajax({
                method:'POST',
                url:'/api/todo/add',
                headers:{
                    'key':'helloatg'
                },
                data:{
                    task:title,
                    user_id:user_id
                },
                success:function(response){
                    console.log(response)
                    if(response.status==1){
                        event.target.tasktitle.value="";
                    }
                    getData();
                },
                error:function(error){
                    console.log(error)
                }
            });
        });
    function getData(){
        const user_id={{Auth::user()->id}}
        $.ajax({
                method:'GET',
                url:'/api/todo/get',
                headers:{
                    'key':'helloatg'
                },
                dataType:'json',
                data:{
                    user_id:user_id
                },
                success:function(response){
                    $('#data').empty();
                    const data=JSON.parse(JSON.stringify(response.task));

                    data.forEach(function(item){
                        if(item.status=="done"){
                            $('#data').append('<li class="list-group-item">'+item.task+'<input type="checkbox" data-task-id='+item.id+' class="form-check-input custom task-status" onchange="getStatus(this)" checked/></li>');
                        }else{
                            $('#data').append('<li class="list-group-item">'+item.task+'<input type="checkbox" data-task-id='+item.id+' class="form-check-input custom task-status" onchange="getStatus(this)"/></li>');
                        }
                    });
                },
                error:function(error){
                    console.log(error)
                }
            });
    }
    function getStatus(value){
        const checkbox=$(this);
        const status=$(value).is(':checked')?'done':'pending';
        const taskId=$(value).data('task-id');
        console.log();
            $.ajax({
                method:'POST',
                url:'/api/todo/status',
                headers:{
                    'key':'helloatg'
                },
                data:{
                    task_id:taskId,
                    status:status
                },
                success:function(response){
                    checkbox.prop('checked',response.message==="Marked task as done")
                    // console.log(response)
                },
                error:function(error){
                    console.log(error)
                }
            });
        }
    function showForm(btn){
        const form=document.getElementById('form');
        if(form.style.display=="block"){
            form.style.display="none";
            btn.innerText="Add Task"
        }else{
            form.style.display="block";
            btn.innerText="Close";
        }
    }
</script>
@endsection
