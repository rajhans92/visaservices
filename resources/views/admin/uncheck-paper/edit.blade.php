@extends('layouts.app')

@section('content')
    <h3 class="page-title">@lang('global.uncheck-paper.title')</h3>

    <div class="panel panel-default">
        <div class="panel-heading">
           <a href="{{ route('admin.uncheck-paper.show',[$exam_schedule_id]) }}" class="btn btn-primary">@lang('global.app_back_to_list')</a>
        </div>
        <div class="panel-body">
          <div class="row">
            <div class="col-xs-12 form-group">
              <h4 style="font-size: 15px;"><b>Exam Name :-</b> {{$exam_name}}</h4>
              <h4 style="font-size: 15px;"><b>User Name :-</b> {{$user_name}}</h4>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 form-group">
            {!! $htmlString !!}
            </div>
          </div>
        </div>

    </div>


@stop
@section('javascript')

<script type="text/javascript">

    $(function(){
       $( "#tabs" ).tabs();
       var exam_schedule_id = {{$exam_schedule_id}};
       var user_id = {{$user_id}};
       var exam_id = {{$exam_id}};
      $(".submitBtn").click(function(){
          var id = $(this).data("id");
          var sectionId = $(this).data("section");
          if(id.length != 0 && sectionId.length != 0){
            var note = $('#question_note'+id).val();
            var isChecked = $('#isChecked'+id).val();
            var isCorrect = $('#isCorrect'+id).val();
            var question_id = id;
            if((note.length != 0 || isChecked.length != 0 || isCorrect.length != 0) && question_id.length != 0 && exam_schedule_id.length != 0 && user_id.length != 0 && exam_id.length != 0){
                $.ajax({
                  url: "/admin/uncheck-paper/paper/"+question_id,
                  type: "PUT",
                  data: {"_token": "{{ csrf_token() }}","is_correct":isCorrect,"is_checked":isChecked,"exam_id":exam_id,'section_id':sectionId,"question_note":note,"exam_schedule_id":exam_schedule_id,"user_id":user_id,"id":question_id},
                  success: function(result){
                    var data = JSON.parse(result);
                    if(!data.error){
                      if(isChecked == 1){
                        $(".is_checked_label_"+id).html("Checked").css("color", "green");
                        if(isCorrect == 1){
                          $(".is_correct_label_"+id).html("Correct").css("color", "green");
                        }else if(isCorrect == 0){
                          $(".is_correct_label_"+id).html("Wrong").css("color", "red");
                        }
                      }else{
                        $(".is_checked_label_"+id).html("Unchecked").css("color", "red");
                        $(".is_correct_label_"+id).html("NA").css("color", "red");
                      }
                    }
                    var alert = confirm(data.msg);
                  }
               });
            }
          }
      });
    });
</script>

@endsection
