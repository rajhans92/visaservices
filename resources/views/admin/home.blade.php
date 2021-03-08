@extends('admin.layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>

                <!-- <div class="panel-body">
                  <div class="row">
                    <div class="col-xs-6 form-group">
                      <canvas id="myChart" height="230" width="450" ></canvas>
                    </div>
                    <div class="col-xs-6 form-group">
                      <canvas id="myChart1" height="230" width="450"></canvas>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-xs-6 form-group">
                      <canvas id="myChart2" height="230" width="450"></canvas>
                    </div>
                    <div class="col-xs-6 form-group">
                      <canvas id="myChart3" height="230" width="450"></canvas>
                    </div>
                  </div>
                </div> -->
            </div>
        </div>
    </div>

@endsection
@section('javascript')
    <script>

    var ctx = document.getElementById('myChart').getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'pie',
      data: {
          labels: ['SSC', 'Banking', 'Engineering', 'MBA', 'Govt Exam'],
          datasets: [{
              label: 'Category Wise',
              data: [12, 19, 3, 5, 5],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
              ],
              borderWidth: 1
          }]
      }
    });

    var ctx1 = document.getElementById('myChart1').getContext('2d');
    var myChart1 = new Chart(ctx1, {
      type: 'line',
      data: {
          labels: ['January', 'February', 'March', 'April', 'May', 'June','July','August','September','October','November', 'December'],
          datasets: [{
              label: 'No of exam attempt per month',
              data: [12, 39, 23, 25, 22, 13, 12, 19, 13, 25, 52, 43],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)',
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)',
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      }
    });

    var ctx2 = document.getElementById('myChart2').getContext('2d');
    var myChart2 = new Chart(ctx2, {
      type: 'bar',
      data: {
          labels: ['No Of Org', 'No Of Teacher', 'No Of Student'],
          datasets: [{
              label: '# of Votes',
              data: [12, 19, 3],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)'
              ],
              borderWidth: 1
          }]
      }
    });

    var ctx3 = document.getElementById('myChart3').getContext('2d');
    var myChart3 = new Chart(ctx3, {
      type: 'doughnut',
      data: {
          labels: ['exam Created', 'exam scheduled', 'Uncheck Exams', 'Exam Result'],
          datasets: [{
              label: '# Total',
              data: [12, 19, 13, 5],
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)'
              ],
              borderWidth: 1
          }]
      }
    });
    </script>
@endsection
