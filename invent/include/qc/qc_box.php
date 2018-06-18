
<!-- แสดงผลกล่อง  -->
<div class="row">
  <div class="col-sm-12" id="box-row">
  <?php $bx = $qc->getBoxList($order->id); ?>
  <?php if( dbNumRows($bx) > 0 ) : ?>
  <?php   while( $rs = dbFetchObject($bx)) : ?>
        <button type="button" class="btn btn-sm btn-default" id="btn-box-<?php echo $rs->id_box; ?>" onclick="printBox(<?php echo $rs->id_box; ?>)">
          <i class="fa fa-print"></i>&nbsp;กล่องที่ <?php echo $rs->box_no; ?>&nbsp; : &nbsp;
          <span id="<?php echo $rs->id_box; ?>"><?php echo number($rs->qty); ?></span>&nbsp; Pcs.
        </button>
  <?php   endwhile; ?>
  <?php else : ?>
    <span id="no-box-label">ยังไม่มีการตรวจสินค้า</span>
  <?php endif; ?>
  </div>
</div>

<hr/>

<script id="box-template" type="text/x-handlebars-template">
  {{#each this}}
<button type="button" class="btn btn-sm {{ class }}" id="btn-box-{{id_box}}" onclick="printBox({{id_box}})">
  <i class="fa fa-print"></i> &nbsp; กล่องที่ {{ no }}&nbsp; : &nbsp;
  <span id="{{id_box}}">{{qty}}</span>&nbsp; Pcs.
</button>
{{/each}}
</script>

<script src="script/qc/qc_box.js"></script>
<!-- แสดงผลกล่อง  -->
