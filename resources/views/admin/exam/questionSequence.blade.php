@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')

@section('content')

<h3 class="page-title">Set Questions sequence for {{$examSection->section_name}}</h3>
    @can('exam_create')
    <p>
        <button class="btn btn-success" id="saveSequence">Save Sequence</button>
        <a href="{{ route('admin.exam.showQuestion',[$exam_id,$section_id]) }}" class="btn btn-warning">Cancel</a>

    </p>
    @endcan



    <div class="panel panel-default">
        <div class="panel-heading">
            Drag row one by one and drop on correct sequence
        </div>

        <div class="panel-body table-responsive">
            <table class="table table-bordered table-striped" >
                <thead>
                    <tr>
                        <th>Question Sequence</th>
                        <th>Question Detail</th>
                        <th>Question Type</th>
                        <th>Question Marks</th>
                        <th>Question Duration</th>
                    </tr>
                </thead>

                <tbody id="tblLocations">
                    @if (count($examQuestions) > 0)
                        @foreach ($examQuestions as $exam)
                            <tr>

                                <td  class="sequence" data-id="{{ $exam->id }}">{{ $exam->question_sequence }}</td>
                                <td>{!!isset($questionDetail[$exam->id]) ? substr($questionDetail[$exam->id]->question_detail,0,10) : ""!!} ...</td>
                                <td>{{ array_key_exists($exam->question_type_id,$questionType) ? $questionType[$exam->question_type_id] : $questionType[0] }}</td>
                                <td>{{ $exam->question_marks }}</td>
                                <td>{{ $exam->question_duration }}</td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop
@section('javascript')
  <script type="text/javascript">
    $(function(){
      let exam_id = '{{$exam_id}}';
      let section_id = '{{$section_id}}';

      $("#tblLocations").sortable({
          items: 'tr',
          cursor: 'pointer',
          axis: 'y',
          dropOnEmpty: false,
          start: function (e, ui) {
              ui.item.addClass("selected");
          },
          stop: function (e, ui) {
              ui.item.removeClass("selected");
              $(this).find("tr").each(function (index) {
                  if (index > 0) {
                      $(this).find("td").eq().html(index);
                  }
              });
              // let count = 1;
              // $(".sequence").each(function() {
              //     $(this).html(count++);
              // });
          }
      });
      $("#saveSequence").click(function(){
          let dataSet = {};
          let count = 1;
          $(".sequence").each(function() {
            dataSet[$(this).attr('data-id')] = count++;
          });
          var result = confirm("Want to Save this sequence?");
          if (result) {
            $(this).val("Loading...");
            var that = $(this);
            $.ajax({
              url: "/admin/exam/questions/sequence/"+exam_id+"/"+section_id,
              data:{"_token": "{{ csrf_token() }}","data":dataSet,"exam_id":exam_id,"section_id":section_id},
              type: "POST",
              success: function(result){
                that.val("Save Sequence");
                var returnResult = confirm("Save successfully!");
              }
           });
          }
      });
    });
  </script>
@endsection
