@extends('agent.agent_dashboard')
 @section('agent')
 
 
 
 <div class="page-content">
 
 				<nav class="page-breadcrumb">
 					<ol class="breadcrumb">
 					 
 					</ol>
 				</nav>
 
 				<div class="row">
 					<div class="col-md-8">
             <div class="card">
               <h6 class="card-title">Schedule Request Details </h6>
  <form method="post" action="{{ route('store.professional.plan') }}">
  	@csrf
 
 
   <div class="table-responsive pt-3">
                   <table class="table table-bordered">
                   
                     <tbody>
       <tr>
         <td>User Name </td>
         <td>{{ $schedule->user->name }}</td>
         
       </tr>
 
       <tr>
         <td>Property Name </td>
         <td>{{ $schedule->property->property_name }}</td>
         
       </tr>
 
 
       <tr>
         <td>Tour Date  </td>
         <td>{{ $schedule->tour_date }}</td>
         
       </tr>
 
 
       <tr>
         <td>Tour Time  </td>
         <td>{{ $schedule->tour_time }}</td>
         
       </tr>
 
 
       <tr>
         <td>Message  </td>
         <td>{{ $schedule->message }}</td>
         
       </tr>
 
       <tr>
         <td>Request Send Time  </td>
         <td>{{ $schedule->created_at->format('l M d Y') }}</td>
         
       </tr>
                       
                     </tbody>
                   </table>
                 </div>
                 <br><br>
 
      <button type="submit" class="btn btn-success">Request Confirm </button>
 		 <br><br>
              
          <div class="table-responsive pt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Progress</th>
                        <th>Salary</th>
                        <th>Start date</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Cedric Kelly</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$206,850</td>
                        <td>June 21, 2022</td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Haley Kennedy</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$313,500</td>
                        <td>May 15, 2022</td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Bradley Greer</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 90%" aria-valuenow="90" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$132,000</td>
                        <td>Apr 12, 2022</td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Brenden Wagner</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$206,850</td>
                        <td>June 21, 2022</td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Bruno Nash</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" style="width: 35%" aria-valuenow="35" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$163,500</td>
                        <td>January 01, 2022</td>
                    </tr>
                    <tr>
                        <td>6</td>
                        <td>Sonya Frost</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-info" role="progressbar" style="width: 65%" aria-valuenow="65" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$103,600</td>
                        <td>July 18, 2022</td>
                    </tr>
                    <tr>
                        <td>7</td>
                        <td>Zenaida Frank</td>
                        <td>
                            <div class="progress">
                                <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" style="width: 20%" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </td>
                        <td>$313,500</td>
                        <td>March 22, 2022</td>
                    </tr>
         </form>
    </div>
 
 
 
 					</div>
 				</div>
 			</div>
 
 
 
 
 
 
 @endsection