<?php
$allProduct = $cs->all_product == 0 ? 'N' : 'Y';

/*
//--- ระบุชื่อสินค้า
$pdList = getRuleProductId($id);
$pdListNo = count($cusList);
$product_id = ($allProduct == 'N' && $pdListNo > 0 ) ? 'Y' : 'N';
*/

//--- กำหนดรุ่นสินค้า
$pdStyle = getRuleProductStyle($id);
$pdStyleNo = count($pdStyle);
$product_style = ($pdStyleNo > 0 && $allProduct == 'N') ? 'Y' : 'N';

//--- กำหนดกลุ่มสินค้า
$pdGroup = getRuleProductGroup($id);
$pdGroupNo = count($pdGroup);
$product_group = ($pdGroupNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';


//--- กำหนดกลุ่มย่อยสินค้า
$pdSub = getRuleProductSubGroup($id);
$pdSubNo = count($pdSub);
$product_sub_group = ($pdSubNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';

//--- กำหนดชนิดสินค้า
$pdType = getRuleProductType($id);
$pdTypeNo = count($pdType);
$product_type = ($pdTypeNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';

//--- กำหนดประเภทสินค้า
$pdKind = getRuleProductKind($id);
$pdKindNo = count($pdKind);
$product_kind = ($pdKindNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';


//--- กำหนดหมวดหมู่สินค้า
$pdCategory = getRuleProductCategory($id);
$pdCategoryNo = count($pdCategory);
$product_category = ($pdCategoryNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';


//--- กำหนดปีสินค้า
$pdYear = getRuleProductYear($id);
$pdYearNo = count($pdYear);
$product_year = ($pdYearNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';


//--- กำหนดยี่ห้อสินค้า
$pdBrand = getRuleProductBrand($id);
$pdBrandNo = count($pdBrand);
$product_brand = ($pdBrandNo > 0 && $allProduct == 'N' && $product_style == 'N') ? 'Y' : 'N';
 ?>
<div class="tab-pane fade" id="product">

	<div class="row">
        <div class="col-sm-8 top-col">
            <h4 class="title">กำหนดเงื่อนไขตามคุณสมบัติสินค้า</h4>
        </div>
				
        <div class="divider margin-top-5"></div>
        <div class="col-sm-2">
					<span class="form-control left-label text-right">สินค้าทั้งหมด</span>
				</div>
        <div class="col-sm-2">
          <div class="btn-group width-100">
          	<button type="button" class="btn btn-sm width-50 btn-primary" id="btn-pd-all-yes" onclick="toggleAllProduct('Y')">YES</button>
						<button type="button" class="btn btn-sm width-50" id="btn-pd-all-no" onclick="toggleAllProduct('N')">NO</button>
          </div>
        </div>
				<div class="divider-hidden"></div>


        <div class="col-sm-2">
					<span class="form-control left-label text-right">รุ่นสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-style-id-yes" onclick="toggleStyleId('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-style-id-no" onclick="toggleStyleId('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-4 padding-5">
					<input type="text" class="option form-control input-sm text-center" id="txt-style-id-box" placeholder="ค้นหารุ่นสินค้า" disabled />
					<input type="hidden" id="id_style" />
				</div>
				<div class="col-sm-1 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block" id="btn-style-id-add" onclick="addStyleId()" disabled><i class="fa fa-plus"></i> เพิ่ม</button>
				</div>
				<div class="col-sm-2 padding-5">
					<span class="form-control input-sm text-center"><span id="psCount"><?php echo $pdStyleNo; ?></span>  รายการ</span>
				</div>
				<div class="col-sm-1 padding-5">
					<button type="button" class="option btn btn-sm btn-primary btn-block" id="btn-show-style-name" onclick="showStyleList()">
						แสดง
					</button>
				</div>
				<div class="divider-hidden"></div>



				<div class="col-sm-2">
					<span class="form-control left-label text-right">กลุ่มสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-group-yes" onclick="toggleProductGroup('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-group-no" onclick="toggleProductGroup('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-group" onclick="showProductGroup()" disabled>
						เลือกกลุ่มสินค้า <span class="badge pull-right" id="badge-pd-group"><?php echo $pdGroupNo; ?></span>
					</button>
				</div>
				<div class="divider-hidden"></div>



        <div class="col-sm-2">
					<span class="form-control left-label text-right">กลุ่มย่อยสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-sub-yes" onclick="toggleProductSubGroup('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-sub-no" onclick="toggleProductSubGroup('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-sub" onclick="showProductSubGroup()" disabled>
						เลือกกลุ่มย่อยสินค้า <span class="badge pull-right" id="badge-pd-sub"><?php echo $pdSubNo; ?></span>
					</button>
				</div>
				<div class="divider-hidden"></div>



				<div class="col-sm-2">
					<span class="form-control left-label text-right">ชนิดสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-type-yes" onclick="toggleProductType('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-type-no" onclick="toggleProductType('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-type" onclick="showProductType()" disabled>
						เลือกชนิดสินค้า <span class="badge pull-right" id="badge-pd-type"><?php echo $pdTypeNo; ?></span>
					</button>
				</div>
				<div class="divider-hidden"></div>



				<div class="col-sm-2">
					<span class="form-control left-label text-right">ประเภทสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-kind-yes" onclick="toggleProductKind('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-kind-no" onclick="toggleProductKind('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-kind" onclick="showProductKind()" disabled>
						เลือกประเภทสินค้า <span class="badge pull-right" id="badge-pd-kind"><?php echo $pdKindNo; ?></span>
					</button>
				</div>
				<div class="divider-hidden"></div>


				<div class="col-sm-2">
					<span class="form-control left-label text-right">หมวดหมู่สินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-cat-yes" onclick="toggleProductCategory('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-cat-no" onclick="toggleProductCategory('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-cat" onclick="showProductCategory()" disabled>
						เลือกเขตสินค้า <span class="badge pull-right" id="badge-pd-cat"><?php echo $pdCategoryNo; ?></span>
					</button>
				</div>
				<div class="divider-hidden"></div>


				<div class="col-sm-2">
					<span class="form-control left-label text-right">ยี่ห้อสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-brand-yes" onclick="toggleProductBrand('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-brand-no" onclick="toggleProductBrand('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-brand" onclick="showProductBrand()" disabled>
						เลือกยี่ห้อสินค้า <span class="badge pull-right" id="badge-pd-brand"><?php echo $pdBrandNo; ?></span>
					</button>
				</div>
				<div class="divider-hidden"></div>

        <div class="col-sm-2">
					<span class="form-control left-label text-right">ปีสินค้า</span>
				</div>
        <div class="col-sm-2">
					<div class="btn-group width-100">
						<button type="button" class="not-pd-all btn btn-sm width-50" id="btn-pd-year-yes" onclick="toggleProductYear('Y')" disabled>YES</button>
						<button type="button" class="not-pd-all btn btn-sm width-50 btn-primary" id="btn-pd-year-no" onclick="toggleProductYear('N')" disabled>NO</button>
					</div>
        </div>
				<div class="col-sm-2 padding-5">
					<button type="button" class="option btn btn-sm btn-info btn-block padding-right-5" id="btn-select-pd-year" onclick="showProductYear()" disabled>
						เลือกยี่ห้อสินค้า <span class="badge pull-right" id="badge-pd-year"><?php echo $pdBrandNo; ?></span>
					</button>
				</div>
        <div class="divider-hidden"></div>
				<div class="col-sm-2">&nbsp;</div>
				<div class="col-sm-3">
					<button type="button" class="btn btn-sm btn-success btn-block" onclick="saveProduct()"><i class="fa fa-save"></i> บันทึก</button>
				</div>


    </div>

		<input type="hidden" id="all_product" value="<?php echo $allProduct; ?>" />
		<!-- <input type="hidden" id="product_id" value="<?php //echo $product_id; ?>" /> -->
    <input type="hidden" id="product_style" value="<?php echo $product_style; ?>" />
		<input type="hidden" id="product_group" value="<?php echo $product_group; ?>" />
    <input type="hidden" id="product_sub" value="<?php echo $product_sub_group; ?>" />
		<input type="hidden" id="product_type" value="<?php echo $product_type; ?>" />
		<input type="hidden" id="product_kind" value="<?php echo $product_kind; ?>" />
		<input type="hidden" id="product_category" value="<?php echo $product_category; ?>" />
		<input type="hidden" id="product_brand" value="<?php echo $product_brand; ?>" />
    <input type="hidden" id="product_year" value="<?php echo $product_year; ?>" />

</div><!--- Tab-pane --->
<?php include 'include/rule/product_rule_modal.php'; ?>
