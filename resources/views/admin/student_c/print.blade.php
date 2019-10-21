<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title> Print คอร์สเรียน {{$courseinfo->title_course}}</title>
  <meta name="description" content="">
  <meta name="author" content="">
  <meta name="keywords" content="">


  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Favicons-->




    <!-- Google web fonts -->
    <link href="https://fonts.googleapis.com/css?family=Itim" rel="stylesheet">

	<style>
			html,body {
		    font-family: "Itim", "cursive";
		    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
		}
    .invoice-title h2, .invoice-title h3 {
        display: inline-block;
    }

    .table > tbody > tr > .no-line {
        border-top: none;
    }

    .table > thead > tr > .no-line {
        border-bottom: none;
    }

    .table > tbody > tr > .thick-line {
        border-top: 2px solid;
    }
    @media (min-width: 1200px){
      .panel {
          margin: 0px;
      }
    }
    .panel-default>.panel-heading {
    background-color: #fff;
    padding: 20px;
    }

    </style>

    <!--[if lt IE 9]>
      <script src="js/html5shiv.min.js"></script>
      <script src="js/respond.min.js"></script>
    <![endif]-->

</head>
<body>
  <div class="container" style="padding-left:25px; padding-right:25px;">
    <div class="row">
        <div class="col-xs-12">


    		<div class="row">
    			<br /><br />
    		</div>
    		<div class="row">
    			<div class="col-xs-5">
    				<address>
    					<strong>สถาบันภาษาญี่ปุ่น ZA-SHI</strong><br>
							458/4 ชั้น 4 สยามสแควร์ ซอย 8 ปทุมวัน กรุงเทพมหานคร 10330
    				</address>
    			</div>
					<div class="col-xs-1">
					</div>
    			<div class="col-xs-6 text-right">
    				<img src="{{asset('./assets/image/logo/Learnsbuy_WebLogo_300.png')}}" style="height:70px;" class="img-thumbnail" />
    			</div>
    		</div>
    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">

    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                    <tr>
        							<td style="width:70px;"><strong>คอร์สเรียน </strong></td>
											<td><strong>{{$courseinfo->title_course}}</strong></td>
                    </tr>
    						</thead>
    						<tbody>
    							<!-- foreach ($order->lineItems as $line) or some such thing here -->
    							<tr>

										<td >
											<strong>กรุณาส่ง</strong>
										</td>

    								<td >


												 {{$courseinfo->name}}<br />
												เบอร์ติดต่อ : {{$courseinfo->phone}}<br />
					    					{{$courseinfo->address}}





										</td>

    							</tr>

    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<script>
			window.print();
		</script>


</body></html>
