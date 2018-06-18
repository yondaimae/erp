<div class="container">
  <div class="row top-row">
    <div class="col-sm-6 top-col">
      <h4 class="title"><i class="fa fa-bar-chart"></i> <?php echo $pageTitle; ?></h4>
    </div>
    <div class="col-sm-6">
      <p class="pull-right top-p">
        <button type="button" class="btn btn-sm btn-success" onclick="getReport()"><i class="fa fa-bar-chart"></i> รายงาน</button>
      </p>
    </div>
  </div>
  <hr/>
  <div class="row">
    <div class="col-sm-12" id="result">

    </div>
  </div>
<style>
.icon-box {
  display: inline-block;
  width:30%;
  height: 60px;
  font-size: 22px;
  padding-top:15px;
  padding-bottom: 15px;
  text-align: center;
  margin: 0px;
  color:#fff;
}

.sub-icon {
  display: inline-block;
  width:30%;
  height: 50px;
  font-size: 18px;
  padding-top:15px;
  padding-bottom: 15px;
  text-align: center;
  margin: 0px;
  color:#fff;
}

.info-box {
  display: inline-block;
  width:70%;
  height: 60px;
  font-size:22px;
  padding:15px;
  margin-left:-4px;
  text-align: right;
  color:#FFF;
}

.sub-info {
  display: inline-block;
  width:70%;
  height: 50px;
  font-size:18px;
  padding:15px;
  margin-left:-4px;
  text-align: right;
  color:#FFF;
}

.i-blue {  background-color: #4A89DC; }
.c-blue {  background-color: #5D9CEC; }
.i-green {  background-color:  #8CC152;}
.c-green {  background-color:  #A0D468;}
.i-yellow { background-color: #F6BB42;}
.c-yellow { background-color: #FFCE54;}
.i-orange { background-color: #E9573F;}
.c-orange { background-color: #FC6E51;}
.i-red { background-color: #DA4453;}
.c-red { background-color: #ED5565;}
</style>
</div><!--/ container -->


<div class="modal fade" id="stockGrid" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog" id="modal">
		<div class="modal-content">
  			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" id="modalTitle">title</h4>
			 </div>
			 <div class="modal-body" id="modalBody"></div>
			 <div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">ปิด</button>
			 </div>
		</div>
	</div>
</div>

<script>
  function getReport(){
    load_in();
    $.ajax({
      url:'controller/stockReportController.php?current_stock&report',
      type:'GET',
      cache:'false',
      success:function(rs){
        load_out();
        $('#result').html(rs);
      }
    });
  }


  function getData(id_style){
  	load_in();
  	$.ajax({
  		url:"controller/stockReportController.php?getStockGrid",
  		type:"GET",
      cache:"false",
      data:{"id_style" : id_style},
  		success: function(rs){
  			load_out();
  			var rs = rs.split(' | ');
  			if( rs.length == 4 ){
  				var grid = rs[0];
  				var width = rs[1];
  				var pdCode = rs[2];

  				$("#modal").css("width", width +"px");
  				$("#modalTitle").html(pdCode);

  				$("#modalBody").html(grid);
  				$("#stockGrid").modal('show');
  			}else{
  				swal("สินค้าไม่ถูกต้อง");
  			}
  		}
  	});
  }

</script>
