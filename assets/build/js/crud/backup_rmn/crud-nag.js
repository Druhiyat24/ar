var save_method; //for save method string
var table;
let dt_dari_book_inv
let dt_sampai_book_inv
let dt_dari
let dt_sampai
let dt_dari_so
let dt_sampai_so
let dt_dari_inv
let dt_sampai_inv
let dt_dari_inv_dd
let dt_sampai_inv_dd
let dt_dari_so_prof
let dt_sampai_so_prof
let dt_dari_prof_inv
let dt_sampai_prof_inv
let dt_dari_rtn_inv
let dt_sampai_rtn_inv
let dt_dari_rtn_sjbpb
let dt_sampai_rtn_sjbpb
let dt_dari_approv
let dt_sampai_approv
let dt_dari_invkwt
let dt_sampai_invkwt
let dt_dari_kwt
let dt_sampai_kwt
let dt_dari_alk
let dt_sampai_alk
var Toast
var base_url = '<?php echo base_url();?>';

//Load Date 
$(document).ready(function () {
	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
        dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
        // 
		dt_dari_prof_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_prof_inv = picker.endDate.format('YYYY-MM-DD');		
		//
		dt_dari_inv_dd = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_inv_dd = picker.endDate.format('YYYY-MM-DD');	
		//	
		dt_dari_so = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_so = picker.endDate.format('YYYY-MM-DD');	
		//
		dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_rtn_sjbpb   = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_rtn_sjbpb = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_rtn_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_rtn_inv = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_so_prof = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_so_prof = picker.endDate.format('YYYY-MM-DD');
		//
		dt_dari_book_inv = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_book_inv = picker.endDate.format('YYYY-MM-DD');

		dt_dari_kwt = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_kwt = picker.endDate.format('YYYY-MM-DD');

		dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');
		//
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
       
    });	
});


$(document).ready(function () {
	$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {

		dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');
		//
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
       
    });	
});

$(document).ready(function () {
	$('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {      
		dt_dari = picker.startDate.format('YYYY-MM-DD');
		dt_sampai = picker.endDate.format('YYYY-MM-DD');	
		//
        $(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
       
    });	
});

//
//Cari TOP
$(document).ready(function () {
		
	// $("select").change(function () {
	// 	$(this).parent().parent().removeClass('has-error');
	// 	$(this).next().empty();
	// });
	//
	// TOP Create Invoice
	document.querySelector("#find_top").addEventListener("click", function(){		
		cari_top()
	})	
});

//Cari Proforma TOP
$(document).ready(function () {		
	// TOP Proforma Invoice
	document.querySelector("#prof_find_top").addEventListener("click", function(){		
		cari_prof_top()
	})
});

//Alert
$(document).ready(function () {		
	// Alert 
	Toast = Swal.mixin({
		toast: true,
		position: 'top-end',
		showConfirmButton: false,
		timer: 3000
	});
	//
   	$('.swalDefaultError').click(function() {
		
	});	
});

function muncul_pesan() { 
	Toast.fire({
	icon: 'error',
	title: 'Sory!!!, File Tidak Bisa di Update'
	})
}

function message_validation(title){ 
	Toast.fire({
	icon: 'info',
	title: title
	})
}

function get_kode_booking_invoice(kode) 
{	
	$.ajax({
		url: "get_kode_book_invoice/" + kode,		
		type: "GET",
		dataType: "JSON",
		success: function (id) {
            
			$('[name="inv_book_number"]').val(id);
						           			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

function modal_book_invoice() {	
	
	let shipp_book  = $('[name="shipp"]').val();	
	let doc_type    = $('[name="doc_type"]').val();	
	let doc_number  = $('[name="doc_number"]').val();	
	let val         = $('[name="val"]').val();

       	//Message Validation
		if (shipp_book == "") {
			let title = "Shipp is required!"
			message_validation(title);		 
	        $("#shipp").focus();			  
		    return false;
		}

		if (doc_type == "") {
			let title = "Document type is required!"
			message_validation(title);			
			$("#doc_type").focus();			  
			return false;
		}

		if (doc_number == "") {		
			let title = "Document number is required!"
			message_validation(title);		
			$("#doc_number").focus();			  
			return false;
		}

		if (val == "") {			
			let title = "Value is required!"
			message_validation(title);		
			$("#val").focus();			  
			return false;
		}

	$('#modal-add-booking-invoice').modal('show')	 	  

	$idbook = $('[name="inv_book_number"]').val()	
	$idcust = $('[name="customer"]').val()	
	$typeshipp = $('[name="shipp"]').val()	
	$doc_type = $('[name="doc_type"]').val()
	$doc_number = $('[name="doc_number"]').val()
	$typevalue    = $('[name="val"]').val()
	$typecomm = $('[name="type"]').val()		
	//
	$('[name="id_inv"]').val($idbook);
	$('[name="id_cust"]').val($idcust);
	$('[name="type_shipp"]').val($typeshipp);
	$('[name="type_doc"]').val($doc_type);
	$('[name="type_doc_number"]').val($doc_number);
	$('[name="type_val"]').val($typevalue);
	$('[name="type_comm"]').val($typecomm);		
}

function getType(id, shipp, status) {
	
    //Cek status shipp local	
	if (status != "DRAFT") { 
		muncul_pesan();
	} else {
	//	
	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "getType/" + id,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="id_book_inv"]').val(data.id);	
			$('[name="doc_number_mdl"]').val(data.doc_number);	
			$('[name="type_mdl"]').val(data.id_type);
			$('[name="no_inv"]').val(data.no_invoice);
			$('[name="docum_type"]').val(data.doc_type);
			$('[name="amount"]').val(data.value);
			//
			$('#modal-update').modal('show'); // show bootstrap modal when complete loaded
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	  });
	}
	
	//Before Filter Shipp Local
	//
	// $('.form-group').removeClass('has-error'); // clear error class
	// $('.help-block').empty(); // clear error string
	
	// //Ajax Load data from ajax
	// $.ajax({
	// 	url: "getType/" + id,
	// 	type: "GET",
	// 	dataType: "JSON",
	// 	success: function (data) {
			
	// 		$('[name="id_book_inv"]').val(data.id);	
	// 		$('[name="peb_mdl"]').val(data.peb);	
	// 		$('[name="type_mdl"]').val(data.id_type);
	// 		$('[name="no_inv"]').val(data.no_invoice);
	// 		//
	// 		$('#modal-update').modal('show'); // show bootstrap modal when complete loaded
			
	// 	},
	// 	error: function (jqXHR, textStatus, errorThrown) {
	// 		alert('Error get data from ajax');
	// 	}
	// });
	
}

function loadbookinvoice(){
	
	$('#table-booking-invoice tbody tr').remove();	

		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_book_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_book_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
			
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_book_inv = "undefined";
			dt_sampai_book_inv = "undefined";
		});

		var id_customer = $('#book_customer').val();
		var status = $('#book_status').val();

	$.ajax({		
		url: "loadbookinvoice/" + dt_dari_book_inv + "/" + dt_sampai_book_inv + "/" + id_customer + "/" + status + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (response) {
				
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";			
				trHTML += '<td>' + item.shipp + "</td>";				
				trHTML += '<td>' + item.tanggal + "</td>";
				trHTML += '<td>' + item.type + "</td>";
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.value + "</td>";	
				trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType(\'' + item.id + '\',\'' + item.shipp + '\', \'' + item.status + '\')">Update</button> ' + '' + ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_booking_invoice(\'' + item.id + '\',\'' + item.no_invoice + '\',\'' + item.status + '\')">Cancel</button></td>';			

				trHTML += '</tr>';
			});

			$('#table-booking-invoice').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function cancel_booking_invoice(id, no_invoice, status){ 

	let status_inv  = status;		
    //Status Post And Approved Tidak Bisa Di Cancel
	if (status_inv == "POST" || status_inv == "APPROVED") {
		let title = "Invoice status POST dan APPROVED tidak bisa di cancel!"
		message_validation(title);	    		  
		return false;
	}

	$('#txt_cancel_book').val(no_invoice);
	$('#id_book_inv').val(id);
	$('#modal-cancel-book').modal('show');  

}

function cancel_invoice(id, no_invoice, status){ 

	let status_inv  = status;		
    
	$('#txt_cancel_book').val(no_invoice);
	$('#id_book_inv').val(id);
	$('#modal-cancel-inv').modal('show');  

}

function cari_book_inv() {

	$('#table-add-bookinvoice tbody tr').remove();	

		//Date range picker
		$('input[name="reservation"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari = picker.startDate.format('YYYY-MM-DD');
			dt_sampai = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari = "undefined";
			dt_sampai = "undefined";
		});
	
	$.ajax({		
		url: "cari_book_inv/" + dt_dari + "/" + dt_sampai + "/",		
		type: "GET",
		dataType: "JSON",
		success: function (response) {
				
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';	
				trHTML += '<td><button id="add_book_inv" name="add_book_inv" type="button" class="btn btn-success btn-sm" onclick="add_no_book_inv()">Add</td>';
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";			
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.tanggal + "</td>";
				trHTML += '<td>' + item.type + "</td>";
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td>' + item.id_customer + "</td>";
				trHTML += '<td>' + item.id + "</td>";
				trHTML += '<td align="right">' + item.amount + "</td>";
				trHTML += '</tr>';
			});

			$('#table-add-bookinvoice').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function add_no_book_inv() {
	
	var table = document.getElementById("table-add-bookinvoice");
	var rows = table.getElementsByTagName("tr");	
	for (i = 0; i < rows.length; i++) {
	  var currentRow = table.rows[i];
	  var createClickHandler = function(row) {
		return function() {
		  // Var Cell	
		  var no_inv_cell     = row.getElementsByTagName("td")[1];
		  var cust_cell       = row.getElementsByTagName("td")[2];
		  var shipp_cell      = row.getElementsByTagName("td")[3];
		  var doc_type_cell   = row.getElementsByTagName("td")[4];
		  var doc_number_cell = row.getElementsByTagName("td")[5];
		  var type_cell       = row.getElementsByTagName("td")[7];	
		  var id_cust_cell    = row.getElementsByTagName("td")[9];
		  var id_inv_cell     = row.getElementsByTagName("td")[10];	
		  var amount_cell     = row.getElementsByTagName("td")[11];			
		  //
		  var no_inv     = no_inv_cell.innerHTML;	
		  var cust       = cust_cell.innerHTML;
		  var shipp      = shipp_cell.innerHTML;
		  var doc_type   = doc_type_cell.innerHTML;
		  var doc_number = doc_number_cell.innerHTML;
		  var type       = type_cell.innerHTML; 
		  var id_cust    = id_cust_cell.innerHTML; 
		  var id_inv     = id_inv_cell.innerHTML; 
		  var amount     = amount_cell.innerHTML; 
		  //
		  document.getElementById("inv_number1").value = no_inv;
		  document.getElementById("cust").value = cust;
		  document.getElementById("shipp").value = shipp;
		  document.getElementById("doc_type").value = doc_type;
		  document.getElementById("doc_number").value = doc_number;
		  document.getElementById("type").value = type;	
		  document.getElementById("id_cust").value = id_cust;	
		  document.getElementById("id_inv").value = id_inv;	 
		  document.getElementById("amount").value = amount;	 	  
		  
		};
	  };
	  currentRow.onclick = createClickHandler(currentRow);
	}	

	$('#modal-add-no-booking-invoice').modal('hide');	

}

function clear_component() {
	//cari_book_inv();
	$('#inv_number1').val("");
	$('#cust').val("");
	$('#shipp').val("");
	$('#doc_type').val("");
	$('#doc_number').val("");
	$('#amount').val("");
	$('#type').val("");
	$('#id_cust').val("");
	$('#table-add-bookinvoice tbody tr').remove();
	$('#table-sj tbody tr').remove();
	$('#top').val("");
	$('#top_time').val("");
	$('#so_number1').val("");
	$('#id_sj').val("");
	$('#id_inv').val("");
	$('#id_top').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#discount').val("");
	$('#dp').val("");
	$('#return').val("");
	$('#twot').val("");
	$('#vat').val("");
	$('#grandtotal').val("");	
	
}

function modal_clear_component() {

	//Hapus Table invoice detail temporary
	delete_invoice_detail_temporary()	
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#mdl_total').val("");
	$('#mdl_discount').val("");
	$('#mdl_dp').val("");
	$('#mdl_return').val("");
	$('#mdl_twot').val("");
	$('#mdl_vat').val("");
	$('#mdl_grandtotal').val("");		
	
}

function cari_top() {
	
	//Clear Component
	$('#tbl_top tbody tr').remove();
	$('#top').val("");
	$('#top_time').val("");
	$('#id_top').val("");
	//
	var id_cust = $('[name="id_cust"]').val()		
	var formData = {
		"id_cust": id_cust,
	};
    //
	$.ajax({		
		url: "cari_top/",		
		type: "POST",
		data: formData,
		dataType: "JSON",
		success: function (response) {
				
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';	
				trHTML += '<td><button id="add_top" name="add_top" type="button" class="btn btn-info btn-sm" onclick="add_top()" >Add</td>';
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.type + "</td>";			
				trHTML += '<td>' + item.top + "</td>";
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";			
				trHTML += '</tr>';
				
			});

			$('#tbl_top').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function add_top() { 
	var table = document.getElementById("tbl_top");
	var rows = table.getElementsByTagName("tr");	
	for (i = 0; i < rows.length; i++) {
	  var currentRow = table.rows[i];
	  var createClickHandler = function(row) {
		return function() {
		  // Var Cell	
		  var type_cell     = row.getElementsByTagName("td")[2];
		  var top_cell      = row.getElementsByTagName("td")[3];
		  var id_cell       = row.getElementsByTagName("td")[5];				
		  //
		  var type   = type_cell.innerHTML;	
		  var top    = top_cell.innerHTML;
		  var id     = id_cell.innerHTML;		 
		  //
		  document.getElementById("top").value = type;
		  document.getElementById("top_time").value = top;	 
		  document.getElementById("id_top").value = id;	 	 	  
		  
		};

	  };
	  currentRow.onclick = createClickHandler(currentRow);
	}	

	$('#modal-add-top').modal('hide');

}

function add_id_for_so() {

	$cust = $('[name="cust"]').val()	
	$idcust = $('[name="id_cust"]').val()	
	//
	$('[name="custm"]').val($cust);
	$('[name="id_custm"]').val($idcust);
	//
	$('#example4 tbody tr').remove();	
	$('#table-sj tbody tr').remove();
	//
	$('#so_number1').val("");
	//$('#id_sj').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#discount').val("");
	$('#dp').val("");
	$('#return').val("");
	$('#twot').val("");
	$('#vat').val("");
	$('#grandtotal').val("");	
	//
	$('#table-sj-2 tbody tr').remove();	
	//
	modal_clear_component();

}

function cari_so() {
	
	$('#example4 tbody tr').remove();	
	$('#table-sj-2 tbody tr').remove();	
	modal_clear_component();

		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_so = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_so = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_so = "undefined";
			dt_sampai_so = "undefined";
		});
			
		//var id_customer = "44";	
		var id_customer = $('#id_custm').val();
					
	$.ajax({		
		url: "cari_so/" + dt_dari_so + "/" + dt_sampai_so + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
							
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';
				//trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_sj" id="pilih_sj" class="flat" value = ' + item.id_so + ' onclick="tambah_sj()"></td>';									
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_sj" id="pilih_sj" class="flat" value = ' + item.id_so + ' onclick="tambah_sj(' + item.id_so + ')"></td>';									
				trHTML += '<td>' + item.so_no + "</td>";
				trHTML += '<td>' + item.so_date + "</td>";	
				trHTML += '<td>' + item.Supplier + "</td>";
				trHTML += '<td>' + item.buyerno + "</td>";
				trHTML += '<td>' + item.so_type + "</td>";	
				trHTML += '<td>' + item.id_so + "</td>";			
				trHTML += '</tr>';
			});

			$('#example4').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
   
}

// function add_so(){ 
	
// 	var table = document.getElementById("example4");
// 	var rows = table.getElementsByTagName("tr");		
// 	for (i = 0; i < rows.length; i++) {
// 	  var currentRow = table.rows[i];
// 	  var createClickHandler = function(row) {
// 		return function() {
// 		  // Var Cell	
// 		  var so_cell        = row.getElementsByTagName("td")[0];
// 		  var id_sj_cell     = row.getElementsByTagName("td")[5];
// 		  // 			
// 		  var so      = so_cell.innerHTML;	
// 		  var id_sj   = id_sj_cell.innerHTML;		  	
// 		  //
// 		  document.getElementById("so_number1").value = so;	 	 	 
// 		  document.getElementById("id_sj").value = id_sj;	
		  
// 		  add_sj(id_sj); //Tambah Detail SO Dari Surat Jalan Atau Bppb

// 		};

// 	  };
// 	  currentRow.onclick = createClickHandler(currentRow);
// 	}		

// 	$('#modal-add-so').modal('hide');	

// }

function tambah_sj() { 
   
	var cek_so = document.getElementsByName("pilih_sj");	
	for (var i = 0; i < cek_so.length; i++) {
		    //Ceklist		
       		if (cek_so[i].checked) {		
				
				$('#table-sj-2 tbody tr').remove();
				modal_clear_component();
				
				$.ajax({		
					url: "cari_sj/" + cek_so[i].value + "/",							
					type: "GET",
					dataType: "JSON",
					success: function (response) {
										
						var trHTML = '';
						$.each(response, function (i, item) {
							trHTML += '<tr>';	
							trHTML += '<td>' + item.id_bppb + "</td>";			
							trHTML += '<td>' + item.no_so + "</td>";
							trHTML += '<td>' + item.sj + "</td>";							
							//trHTML += '<td>' + item.bppbdate + "</td>";
							trHTML += '<td><input type="text" id="cek_tgl" name="cek_tgl" style="border:none; width:120px;" value = ' + item.bppbdate + ' readonly></td>';									
							trHTML += '<td>' + item.shipping_number + "</td>";		
							trHTML += '<td>' + item.ws + "</td>";	
							trHTML += '<td>' + item.styleno + "</td>";	
							trHTML += '<td>' + item.product_group + "</td>";
							trHTML += '<td>' + item.product_item + "</td>";	
							trHTML += '<td>' + item.color + "</td>";
							trHTML += '<td>' + item.size + "</td>";
							trHTML += '<td>' + item.curr + "</td>";	
							trHTML += '<td>' + item.uom + "</td>";
							trHTML += '<td>' + item.qty + "</td>";
							trHTML += '<td>' + item.unit_price + "</td>";				
							trHTML += '<td><input type="text" class="form-control" id="mdl_disc" name="mdl_disc" style="width: 80%; text-align: center" onkeypress="javascript:return isNumber(event)" oninput="modal_input_discount(value)" readonly autocomplete="off"></td>';		
							trHTML += '<td class="totalsj" align="right">' + item.total_price + "</td>";	
							trHTML += '<td><input type="checkbox" name="mdl_cek_sj" id="mdl_cek_sj" class="flat" value = ' + item.total_price + ' onclick="modal_sum_total_sj(value = ' +  item.total_price + ')"></td>';									
							trHTML += '</tr>';
						});
			
						$('#table-sj-2').append(trHTML);				
						
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
					
			} else { 
				$('#table-sj-2 tbody tr').remove();
				modal_clear_component();
			}					
  	  }
}

function add_data_invoice() { 

	let no_invoice   = $('[name="inv_number1"]').val();
	let top          = $('[name="top"]').val();
       if (no_invoice == "") {
          alert("Invoice Number is required");
		  $("#inv_number1").focus();	
          return false;
  		}

		if (top == "") {
		  alert("Top is required");
		  $("#top").focus();	
		  return false;
		}  
	
	$no_invoice = $('[name="inv_number1"]').val()	
	$id_inv     = $('[name="id_inv"]').val()	
	$pph     = $('[name="pph"]').val()
	//
	$('[name="no_inv_post"]').val($no_invoice);
	$('[name="id_inv_post"]').val($id_inv);
	$('[name="pph_post"]').val($pph);

	$('#modal-simpan-invoice').modal('show')	
    	
}

function save_invoice() {
	
	update_invoice_header();
	update_status_bppb();
	simpan_invoice_detail();
	simpan_invoice_pot();	
	//	
	$('#modal-simpan-invoice').modal('hide');
	
}

function update_invoice_header() { 
	
	var id_inv  = $('[name="id_inv"]').val()		
	var no_inv  = $('[name="inv_number1"]').val()	
	var pph     = $('[name="pph"]').val()	
	var id_top  = $('[name="id_top"]').val()			
	var id_bank = $('[name="id_bank"]').val()
	var type_so = $('[name="type_so"]').val()

	var formData = {
		"id_inv": id_inv,
		"inv_number1": no_inv,
		"pph": pph,
		"id_top": id_top,
		"id_bank": id_bank,		
		"type_so": type_so,	
			
	};
	
	$.ajax({						
		url: "update_invoice_header/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		
					
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Update Invoice Header'
			} else {
				msg = 'Error Update Invoice Header'
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Update Invoice Header' + jqXHR.text
		}
	});

}

function update_status_bppb() { 

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {	
				//   
				var id_bppb = table.rows[i].cells[0].innerHTML
				var no_invoice = $('[name="id_inv"]').val()
                //
				var formData = {
					"id_bppb": id_bppb,
					"no_invoice": no_invoice,

				};
				//
				$.ajax({						
					url: "update_status_bppb/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
		}				
}

function simpan_invoice_detail() 
{ 	
	// return new Promise(resolve => {		
	// 	setTimeout(() => {
	// 		var msg
	// 		var data = [];		

	// 		$("#table-sj input[name='cek_pilih_sj']:checked").each(function () {			
	// 			var rows = $(this).closest("tr")[0];	
																															
	// 			data.push({		
	// 				"id_book_invoice": $('#id_inv').val(),
	// 				"so_number": rows.cells[0].innerHTML,
	// 				"bppb_number": rows.cells[1].innerHTML,	
	// 				"sj_date": rows.cells[2].innerHTML,					
	// 				"shipp_number": rows.cells[3].innerHTML,
	// 				"ws": rows.cells[4].innerHTML,
	// 				"style_name": rows.cells[5].innerHTML,
	// 				"prd_grp": rows.cells[6].innerHTML,
	// 				"curr": rows.cells[7].innerHTML,
	// 				"uom": rows.cells[8].innerHTML,
	// 				"qty": rows.cells[9].innerHTML,
	// 				"unit_price": rows.cells[10].innerHTML,			
	// 				"disc": rows.cells[11].innerHTML,	
	// 				"total_price": rows.cells[12].innerHTML, 									
																			
	// 			})		
				
	// 		})
								
	// 		var fdata = {
	// 			'data_table': data
	// 		}
	// 		$.ajax({				
	// 			url: "simpan_invoice_detail/",
	// 			type: "POST",
	// 			data: fdata,
	// 			dataType: "JSON",
	// 			success: function (data) {
					
	// 				if (data.status) //if success close modal and reload ajax table
	// 				{
	// 					msg = 'Success Input Detail'
	// 				} else {
	// 					msg = 'Error Input Detail'
	// 				}
	// 				// Delete Table Invoice Detail Temporary
	// 				delete_invoice_detail_temporary();
    //                 // Reload Page
	// 				window.location.href = window.location.href;

	// 			},
	// 			error: function (jqXHR, textStatus, errorThrown) {
	// 				msg = 'Error Input Detail' + jqXHR.text
	// 			}
	// 		});
	// 		resolve({
	// 			msg: msg,
	// 		});

	// 	}, 100);
	// });
	//
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {
				
				data.push({		
					"id_book_invoice": $('#id_inv').val(),
					"id_bppb": table.rows[i].cells[0].innerHTML,
					"so_number": table.rows[i].cells[1].innerHTML,
					"bppb_number": table.rows[i].cells[2].innerHTML,	
					"sj_date": table.rows[i].cells[3].innerHTML,					
					"shipp_number":table.rows[i].cells[4].innerHTML,
					"ws": table.rows[i].cells[5].innerHTML,
					"styleno": table.rows[i].cells[6].innerHTML,
					"product_group": table.rows[i].cells[7].innerHTML,
					"product_item": table.rows[i].cells[8].innerHTML,
					"color": table.rows[i].cells[9].innerHTML,
					"size": table.rows[i].cells[10].innerHTML,
					"curr": table.rows[i].cells[11].innerHTML,
					"uom": table.rows[i].cells[12].innerHTML,
					"qty": table.rows[i].cells[13].innerHTML,
					"unit_price": table.rows[i].cells[14].innerHTML,			
					"disc": table.rows[i].cells[15].innerHTML,	
					"total_price": table.rows[i].cells[16].innerHTML, 									
																			
				})		
			}
															
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  
               			
}

function simpan_invoice_pot() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
			var id_book_invoice = $('#id_inv').val();
            var total           = $('#total').val();
            var discount        = $('#discount').val();
            var dp              = $('#dp').val();
            var retur           = $('#return').val();
            var twot            = $('#twot').val();
            var vat             = $('#vat').val();
            var grand_total     = $('#grandtotal').val();
			//			
		   	data.push({		
					"id_book_invoice": id_book_invoice,
					"total": total,
					"discount": discount,	
					"dp": dp,					
					"retur": retur,
					"twot": twot,
					"vat": vat,	
					"grand_total": grand_total,																
				})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_pot/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					delete_invoice_detail_temporary();
					// Print Preview Invoice
					let id_invoice = $('[name="id_inv"]').val();
					print_invoice(id_invoice);
                    // Reload Page
					window.location.href = window.location.href;

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function cari_invoice() { 

	$('#table-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_inv   = "undefined";
			dt_sampai_inv = "undefined";
		});

		var id_customer = $('#customer').val();	

		
							
	$.ajax({		
		url: "cari_invoice/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				if(item.status == 'POST' ){				
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.tgl_inv + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td align="right">' + item.amount + "</td>";
				trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail(' + item.id + ')" >Cek Detail</button> ' + '' 
				+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				+ '<button id="export_to_excel_invoice" name="export_to_excel_invoice" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> ' + ''				
				+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_invoice(\'' + item.id + '\',\'' + item.no_invoice + '\',\'' + item.status + '\')">Cancel</button></td> </td>';
				
				trHTML += '</tr>';
			}else{
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.tgl_inv + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td align="right">' + item.amount + "</td>";
				trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail(' + item.id + ')" >Cek Detail</button> ' + '' 
				+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				+ '<button id="export_to_excel_invoice" name="export_to_excel_invoice" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> </td>';
				
				trHTML += '</tr>';
			}
			});

			$('#table-invoice').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function cari_inv_detail(id_inv) { 
	
	$('#table-inv-detail tbody tr').remove();		
	$('#modal-inv-detail').modal('show');
	$.ajax({		
		url: "cari_inv_detail/" + id_inv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
							
			var trHTML = '';
			$.each(response, function (i, item) { 			
				trHTML += '<tr>';										
				trHTML += '<td>' + item.so_number + "</td>";
				trHTML += '<td>' + item.bppb_Number + "</td>";	
				trHTML += '<td>' + item.shipp_number + "</td>";
				trHTML += '<td>' + item.ws + "</td>";
				trHTML += '<td>' + item.styleno + "</td>";
				trHTML += '<td>' + item.product_group + "</td>";
				trHTML += '<td>' + item.product_item + "</td>";
				trHTML += '<td>' + item.color + "</td>";
				trHTML += '<td>' + item.size + "</td>";
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + item.uom + "</td>";
				trHTML += '<td>' + item.qty + "</td>";
				trHTML += '<td>' + item.unit_price + "</td>";	
				trHTML += '<td>' + item.disc + "</td>";				
				trHTML += '<td align="right">' + item.total_price + "</td>";				
				trHTML += '</tr>';
                //
				$('#inv_number_list').val(item.no_invoice)
				//				
			});
			
			$('#table-inv-detail').append(trHTML);
			
			cari_inv_pot(id_inv);						
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
	
}

function cari_inv_pot(id_inv_pot){ 

	$('#mdl_total_det').val("");
	$('#mdl_discount_det').val("");
	$('#mdl_dp_det').val("");
	$('#mdl_return_det').val("");
	$('#mdl_twot_det').val("");
	$('#mdl_vat_det').val("");
	$('#mdl_grandtotal_det').val("");	
	
	$.ajax({		
		url: "cari_inv_pot/" + id_inv_pot + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {							
			
			$.each(response, function (i, item) { 

				$('#mdl_total_det').val(item.total);
				$('#mdl_discount_det').val(item.discount);
				$('#mdl_dp_det').val(item.dp);
				$('#mdl_return_det').val(item.retur);
				$('#mdl_twot_det').val(item.twot);
				$('#mdl_vat_det').val(item.vat);
				$('#mdl_grandtotal_det').val(item.grand_total);	
								
			});
						
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function isNumber(evt) {
	
	var iKeyCode = (evt.which) ? evt.which : evt.keyCode
	if (iKeyCode != 46 && iKeyCode > 31 && (iKeyCode < 48 || iKeyCode > 57))
		return false;
	return true;	

}

function tampil_tanggal_1(){		
		$('[name="date1"]').val("");		
		$('#modal-show-date1').modal('show');	
}

function tampil_tanggal_2(){		
	$('[name="date2"]').val("");		
	$('#modal-show-date2').modal('show');	
}

function tambah_tanggal_1(){	
		$date1 = $('[name="reservationdate"]').val()
		$('[name="date1"]').val($date1);	    	
		$('#modal-show-date1').modal('hide');
}

function tambah_tanggal_2(){	
	$date2 = $('[name="reservationdate2"]').val()
	$('[name="date2"]').val($date2);	    	
	$('#modal-show-date2').modal('hide');
}

function modal_sum_total_sj(){

	add_value_tgl();
	
	var hanya_baca = document.getElementsByName("mdl_disc");	
	var input = document.getElementsByName("mdl_cek_sj");
  	var total = 0;	
	//    	
    for (var i = 0; i < input.length; i++) {
		for (var i = 0; i < hanya_baca.length;  i++){
       		if (input[i].checked) {		
  				hanya_baca[i].readOnly = false;			
				total += parseFloat(input[i].value);

    		} else {				
				hanya_baca[i].readOnly = true;
				hanya_baca[i].value = '';
				modal_input_discount();
					
			}			
			
		}

  	}
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	var retur = $('[name="mdl_return"]').val(); 	 		
  	document.getElementsByName("mdl_total")[0].value = total.toFixed(2);	
	document.getElementsByName("mdl_grandtotal")[0].value = (total-discount-dp-retur).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total-discount-dp-retur).toFixed(2);
		  	
}

function modal_input_discount(value){ 
		
	var input = document.getElementsByName("mdl_cek_sj");
  	var total = 0;	
	//
	var arr = document.getElementsByName('mdl_disc');
    var tot = 0;
    for(var i = 0; i < arr.length; i++){
		for (var i = 0; i < input.length; i++) {
			if (input[i].checked) {
				   total = parseFloat(input[i].value);
			   if(parseFloat(arr[i].value))
            	   tot += parseFloat(arr[i].value) / 100 * total;	   

			 } 
		}	        
    }		
    document.getElementById('mdl_discount').value = tot.toFixed(2);
	//Grand Total
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	var retur = $('[name="mdl_return"]').val(); 			
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	   			
}

function modal_input_dp(){ 
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp).toFixed(2);
}

function modal_input_retur() { 
	var total_sj = $('[name="mdl_total"]').val();
	var discount = $('[name="mdl_discount"]').val();
	var dp = $('[name="mdl_dp"]').val(); 
	var retur = $('[name="mdl_return"]').val(); 
	document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	document.getElementsByName("mdl_twot")[0].value = (total_sj- discount-dp-retur).toFixed(2);
}

function modal_input_vat(){ 

	var vat = 0.1; 
    //
	if ($('[name="check_vat"]').is(':checked')) {			
			var total_sj = $('[name="mdl_total"]').val();
			var discount = $('[name="mdl_discount"]').val();
			var dp = $('[name="mdl_dp"]').val(); 
			var retur = $('[name="mdl_return"]').val(); 	
			var twot = (total_sj- discount-dp-retur).toFixed(2) * vat;
			document.getElementsByName("mdl_vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur+twot).toFixed(2);	
	} else { 		
		 	var total_sj = $('[name="mdl_total"]').val();
			var discount = $('[name="mdl_discount"]').val();
			var dp = $('[name="mdl_dp"]').val(); 
			var retur = $('[name="mdl_return"]').val(); 
			document.getElementsByName("mdl_vat")[0].value = "0.00";
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	}
}

function modal_input_vat_baru(){ 

	var vat = 0.11; 
    //
	if ($('[name="check_vat_baru"]').is(':checked')) {			
			var total_sj = $('[name="mdl_total"]').val();
			var discount = $('[name="mdl_discount"]').val();
			var dp = $('[name="mdl_dp"]').val(); 
			var retur = $('[name="mdl_return"]').val(); 	
			var twot = (total_sj- discount-dp-retur).toFixed(2) * vat;
			document.getElementsByName("mdl_vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur+twot).toFixed(2);	
	} else { 		
		 	var total_sj = $('[name="mdl_total"]').val();
			var discount = $('[name="mdl_discount"]').val();
			var dp = $('[name="mdl_dp"]').val(); 
			var retur = $('[name="mdl_return"]').val(); 
			document.getElementsByName("mdl_vat")[0].value = "0.00";
			document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur).toFixed(2);
	}
}

function duplicate_data_so(){ 
	
	//Tambah Data Potongan Invoice
	var total       = $('[name="mdl_total"]').val();
    var discount    = $('[name="mdl_discount"]').val();
    var dp          = $('[name="mdl_dp"]').val(); 
    var retur       = $('[name="mdl_return"]').val(); 
    var twot        = $('[name="mdl_twot"]').val(); 
    var vat         = $('[name="mdl_vat"]').val(); 
    var grand_total = $('[name="mdl_grandtotal"]').val(); 	
	$('[name="total"]').val(total);
    $('[name="discount"]').val(discount);
    $('[name="dp"]').val(dp); 
    $('[name="return"]').val(retur); 
    $('[name="twot"]').val(twot); 
    $('[name="vat"]').val(vat); 
    $('[name="grandtotal"]').val(grand_total); 	
	//Hapus Temporary Table Detail SJ
	//Simpan Table SJ Temp
	delete_invoice_detail_temporary()	
	simpan_invoice_detail_temporary();	

}

function simpan_invoice_detail_temporary() {
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-sj-2 input[name='mdl_cek_sj']:checked").each(function () {
				var rows = $(this).closest("tr")[0];

				$(this).closest('tr').find("input[name='mdl_disc']").each(function() {				
				var mdl_disc = this.value	
				
				$(this).closest('tr').find("input[name='cek_tgl']").each(function() {				
					var tgl_sj = this.value	
																
				data.push({			
					"id_bppb": rows.cells[0].innerHTML,				
					"so_number": rows.cells[1].innerHTML,
					"bppb_number": rows.cells[2].innerHTML,	
					"sj_date": tgl_sj,						
					"shipp_number": rows.cells[4].innerHTML,
					"ws": rows.cells[5].innerHTML,
					"styleno": rows.cells[6].innerHTML,
					"product_group": rows.cells[7].innerHTML,
					"product_item": rows.cells[8].innerHTML,
					"color": rows.cells[9].innerHTML,
					"size": rows.cells[10].innerHTML,
					"curr": rows.cells[11].innerHTML,
					"uom": rows.cells[12].innerHTML,
					"qty": rows.cells[13].innerHTML,
					"unit_price": rows.cells[14].innerHTML,			
					"disc": mdl_disc,
					"total_price": rows.cells[16].innerHTML, 				
				})	

			  });
				
		    });
								
		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SJ Temporary
					load_invoice_detail_temporary();                   		
					$('#modal-add-so').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function load_invoice_detail_temporary() { 	
		  	
	$('#table-sj tbody tr').remove();
	    $.ajax({		
		    url: "load_invoice_detail_temporary/",							
			type: "GET",
			dataType: "JSON",
			    success: function (response) {
					var trHTML = '';
					$.each(response, function (i, item) {
						trHTML += '<tr>';
						trHTML += '<td>' + item.id_bppb + "</td>";				
						trHTML += '<td>' + item.so_number + "</td>";
						trHTML += '<td>' + item.bppb_number + "</td>";							
					    trHTML += '<td>' + item.sj_date + "</td>";						
						trHTML += '<td>' + item.shipp_number + "</td>";		
						trHTML += '<td>' + item.ws + "</td>";	
						trHTML += '<td>' + item.styleno + "</td>";	
						trHTML += '<td>' + item.product_group + "</td>";	
						trHTML += '<td>' + item.product_item + "</td>";
						trHTML += '<td>' + item.color + "</td>";
						trHTML += '<td>' + item.size + "</td>";
						trHTML += '<td>' + item.curr + "</td>";	
						trHTML += '<td>' + item.uom + "</td>";
						trHTML += '<td>' + item.qty + "</td>";
						trHTML += '<td>' + item.unit_price + "</td>";
						trHTML += '<td>' + item.disc + "</td>";	
						trHTML += '<td align="right">' + item.total_price + "</td>";	
						// trHTML += '<td><input type="checkbox" name="cek_pilih_sj" id="cek_pilih_sj" class="flat" checked></td>';												
						trHTML += '</tr>';
				    });
						$('#table-sj').append(trHTML);						
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
			}
	  });  	  

}

function delete_invoice_detail_temporary() { 
			
	$.ajax({						
		url: "delete_invoice_detail_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function cari_invoice_post(){ 
	
	$('#table-approval-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});
							
	$.ajax({		
		url: "cari_invoice_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";					
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_approv" id="pilih_inv_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

			$('#table-approval-invoice').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function check_approv_invoice(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}

function modal_show_approve_invoice() { 

	var cek_inv = document.getElementsByName("pilih_inv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {				   
			    	$('#modal-approve-invoice').modal('show');  
			} 
	}	
}

function approve_invoice(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
				var formData = {
					"id_inv": id_inv,			
				};
				//
				$.ajax({						
					url: "approve_invoice/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-invoice').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
		} 
	}
	
}

//  async function refresh(){
//    var result = await approve_invoice()
//    console.log(result);
//    alert("Approve Successfully");
//    cari_invoice_post();
// }

async function refresh(){
   var result = await approve_invoice()
   console.log(result);
   var cek_inv = document.getElementsByName("pilih_inv_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				var coba = parseInt(i + 1);		
				}
			}
   alert(" Invoice Successfully Approved");
   cari_invoice_post();
}


// function sum_total_sj(){

// 	var hanya_baca = document.getElementsByName("disc");	
// 	var input = document.getElementsByName("cek_sj");
//   	var total = 0;	
// 	//    	
//     for (var i = 0; i < input.length; i++) {
// 		for (var i = 0; i < hanya_baca.length;  i++){
//        		if (input[i].checked) {		
//   				hanya_baca[i].readOnly = false;			
// 				total += parseFloat(input[i].value);

//     		} else {				
// 				hanya_baca[i].readOnly = true;
// 				hanya_baca[i].value = '';
// 				input_discount();
					
// 			}			
			
// 		}

//   	}
// 	var discount = $('[name="discount"]').val();
//   	document.getElementsByName("total")[0].value = total.toFixed(2);	
// 	document.getElementsByName("grandtotal")[0].value = (total - discount).toFixed(2);
	  	
// }

// function input_discount(value){ 
		
// 	var input = document.getElementsByName("cek_sj");
//   	var total = 0;	
// 	//
// 	var arr = document.getElementsByName('disc');
//     var tot=0;
//     for(var i = 0; i < arr.length; i++){
// 		for (var i = 0; i < input.length; i++) {
// 			if (input[i].checked) {
// 				   total = parseFloat(input[i].value);
// 			   if(parseInt(arr[i].value))
//             	   tot += parseInt(arr[i].value) / 100 * total;	   

// 			 } 
// 		   }	        
//     }		
//     document.getElementById('discount').value = tot.toFixed(2);
// 	//Grand Total
// 	var total_sj = $('[name="total"]').val();
// 	var discount = $('[name="discount"]').val();		
// 	document.getElementsByName("grandtotal")[0].value = (total_sj- discount).toFixed(2);
			
// }

function add_value_tgl() { 
	
	var cek_sj_1 = document.getElementsByName("mdl_cek_sj");
	var cek_tgl_1 = document.getElementsByName("cek_tgl");		
	//	
	for (var i = 0; i < cek_sj_1.length; i++) {	
		for (var i = 0; i < cek_tgl_1.length; i++) { 
			// 	
	    	if (cek_sj_1[i].checked) {								
				cek_tgl_sj(cek_tgl_1[i].value);
			} 
  	    }	
	}
}

function cek_tgl_sj($tgl){ 
		
	var cek_sj_2 = document.getElementsByName("mdl_cek_sj");
	var cek_tgl_2 = document.getElementsByName("cek_tgl");	
	//
	for (var i = 0; i < cek_sj_2.length; i++) {
	   for (var i = 0; i < cek_tgl_2.length; i++) {	
          //
		  if (cek_tgl_2[i].value != $tgl ) {			
			  cek_sj_2[i].style.display = "none";		
		  }
	   }	
	}
}

function print_invoice(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_invoice3/" + id + "/" );  	
		
}

function export_to_excel_invoice($id) { 			
	window.open(".../../export_excel_invoice/" + $id + "/");  
}

function export_list_invoice() { 		
	var id_customer = $('#customer').val();	
	window.open(".../../export_excel_list_invoice/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/" ); 
}

function export_book_invoice() { 		
	var id_customer = $('#book_customer').val();
	var status = $('#book_status').val();
	window.open(".../../export_excel_book_invoice/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/"+ "/" + status + "/" ); 
}

//Update Duedate
function cari_invoice_dd() { 
	$('#example2 tbody tr').remove();	
	//Date range picker
	$('input[name="reservation2"]').daterangepicker({
		autoUpdateInput: false,
		locale: {
			cancelLabel: 'Clear'
		}
	});

	$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
		dt_dari_inv_dd = picker.startDate.format('YYYY-MM-DD');
		dt_sampai_inv_dd = picker.endDate.format('YYYY-MM-DD');
		$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
	});

	$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
		$(this).val('');
		dt_dari_inv_dd   = "undefined";
		dt_sampai_inv_dd = "undefined";
	});

	var id_customer = $('#customer_dd').val();	
						
    $.ajax({		
			url: "cari_invoice_duedate/" + dt_dari_inv_dd + "/" + dt_sampai_inv_dd + "/" + id_customer + "/",					
			type: "GET",
			dataType: "JSON",
			success: function (response) {
									
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.tanggal + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_dd" id="pilih_inv_dd" class="flat"></td>';												
				trHTML += '</tr>';
			});

		$('#example2').append(trHTML);				
		
		},
		error: function (jqXHR, textStatus, errorThrown) {
		alert('Error get data from ajax');
		}
	});	
}

function save_duedate() { 

	let kb_date = $('[name="tgl_kontrabon"]').val();	
       if (kb_date == "") {
          alert("Kontrabon date is required");
		  $("#tgl_kontrabon").focus();		  
          return false;
  		}
		 
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
			var id_inv = "";

			$("#example2 input[name='pilih_inv_dd']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//Set Now Date
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1; 
				var yyyy = today.getFullYear();	
				today = yyyy+'-'+mm+'-'+dd;
				//
				var no_duedate = $('#doc_dd').val();				
				var kontrabon_date = $('#tgl_kontrabon').val();
				var catatan = $('#cat_dd').val();
				var status = "DONE"				
				//ID Book Invoice
				id_inv = rows.cells[8].innerHTML
				//
				data.push({							
					"no_duedate": no_duedate,
					"id_invoice": rows.cells[8].innerHTML,	
					"no_invoice": rows.cells[0].innerHTML,	
					"input_date": today,				
					"kontrabon_date": kontrabon_date,
					"catatan": catatan,		
					"status": status,												
				})								
		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "save_duedate/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Update duedate bookinvoice
					update_duedate_bookinvoice(id_inv);										                 		
					$('#modal-update-duedate').modal('hide');
					//Reload Page
					location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function update_duedate_bookinvoice(id_inv) { 
			
	var no_duedate  = $('[name="doc_dd"]').val()
	//
	var formData = {
		"no_duedate": no_duedate,							
	};
	
	$.ajax({						
		url: "update_duedate_bookinvoice/" + id_inv + "/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		
					
			if (data.status) //if success close modal and reload ajax table
			{
				msg = ''
			} else {
				msg = ''
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//alert('Error Update Book Invoice ' + jqXHR.text)
		}
	});

}

function reload_page_duedate() { 
	location.reload();	
}

//Proforma Invoice
function get_kode_proforma_invoice(kode) 
{	
	$.ajax({
		url: "get_kode_proforma_invoice/" + kode,		
		type: "GET",
		dataType: "JSON",
		success: function (id) {
            
			$('[name="prof_inv_number"]').val(id);
						           			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

function cari_prof_top() {
		
	//Clear Component
	$('#tbl_prof_top tbody tr').remove();
	$('#prof_top').val("");
	$('#prof_top_time').val("");
	$('#prof_id_top').val("");
	//		
	var id_cust = $('[name="prof_customer"]').val()		
	var formData = {
		"id_cust": id_cust,		
	};
    //
	$.ajax({		
		url: "cari_prof_top/" + id_cust + "/",		
		type: "POST",		
		data: formData,
		dataType: "JSON",
		success: function (response) {
				
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';	
				trHTML += '<td><button id="prof_add_top" name="prof_add_top" type="button" class="btn btn-info btn-sm" onclick="add_prof_top()" >Add</td>';
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.type + "</td>";			
				trHTML += '<td>' + item.top + "</td>";
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";			
				trHTML += '</tr>';
				
			});

			$('#tbl_prof_top').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function add_prof_top() { 
	var table = document.getElementById("tbl_prof_top");
	var rows = table.getElementsByTagName("tr");	
	for (i = 0; i < rows.length; i++) {
	  var currentRow = table.rows[i];
	  var createClickHandler = function(row) {
		return function() {
		  // Var Cell	
		  var type_cell     = row.getElementsByTagName("td")[2];
		  var top_cell      = row.getElementsByTagName("td")[3];
		  var id_cell       = row.getElementsByTagName("td")[5];				
		  //
		  var type   = type_cell.innerHTML;	
		  var top    = top_cell.innerHTML;
		  var id     = id_cell.innerHTML;		 
		  //
		  document.getElementById("prof_top").value = type;
		  document.getElementById("prof_top_time").value = top;	 
		  document.getElementById("prof_id_top").value = id;	 	 	  
		  
		};

	  };
	  currentRow.onclick = createClickHandler(currentRow);
	}	

	$('#modal-add-prof-top').modal('hide');

}

function add_id_for_proforma_inv(){ 	
	
	delete_invoice_detail_proforma_temporary();
    //
	$('#example4 tbody tr').remove();	
	$('#table-proforma-invoice tbody tr').remove();	
	$('[name="prof_grandtotal"]').val("");
	$('[name="prof_dp"]').val("");
	$('[name="prof_dp"]').prop('readonly', true);
	$('[name="prof_check_dp"]').prop('checked', false);
	//
	$cust_prof = $("#prof_customer :selected").text(); 	
	$idcust_prof = $('[name="prof_customer"]').val()	
	//
	$('[name="prof_custm"]').val($cust_prof);
	$('[name="prof_id_custm"]').val($idcust_prof);

}

function cari_so_proforma(){ 
	
	$('#example4 tbody tr').remove();	
	$('#table-proforma-invoice tbody tr').remove();	
	
	//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_so_prof = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_so_prof = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_so_prof = "undefined";
			dt_sampai_so_prof = "undefined";
		});
					
		var id_customer = $('#prof_id_custm').val();
					
	$.ajax({		
		url: "cari_so_proforma/" + dt_dari_so_prof + "/" + dt_sampai_so_prof + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
							
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';				
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_so_proforma" id="pilih_so_proforma" class="flat"></td>';									
				trHTML += '<td>' + item.so_no + "</td>";
				trHTML += '<td>' + item.so_date + "</td>";	
				trHTML += '<td>' + item.Supplier + "</td>";
				trHTML += '<td>' + item.buyerno + "</td>";
				trHTML += '<td align="center">' + item.curr + "</td>";
				trHTML += '<td align="right">' + item.qty + "</td>";	
				trHTML += '<td align="right">' + item.unit_price + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";
				trHTML += '<td align="center">' + item.id_so + "</td>";					
				trHTML += '</tr>';
			});

			$('#example4').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
   
	
}

function duplicate_data_so_proforma(){ 

	delete_invoice_detail_proforma_temporary()
	simpan_invoice_detail_proforma_temporary()
		
}

function simpan_invoice_detail_proforma_temporary(){
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];	
			
			$("#example4 input[name='pilih_so_proforma']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//
				var qty = rows.cells[6].innerHTML; 
				var unit_price = rows.cells[7].innerHTML;
				var total_price = rows.cells[8].innerHTML;
				//
				qty = qty.replace(/,/g, '');
				unit_price = unit_price.replace(/,/g, '');
				total_price = total_price.replace(/,/g, '');
                //
				data.push({							
					//"id_invoice_proforma": rows.cells[0].innerHTML,
					"so_no": rows.cells[1].innerHTML,	
					"so_date": rows.cells[2].innerHTML,						
					"buyerno": rows.cells[4].innerHTML,
					"curr": rows.cells[5].innerHTML,
					"qty": qty,
					"unit_price": unit_price,					
					"total_price": total_price,
					"id_so": rows.cells[9].innerHTML,									
				})			 
								
		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail_proforma_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SO Proforma Temporary
					load_invoice_detail_proforma_temporary();                   		
					$('#modal-add-so-proforma').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function load_invoice_detail_proforma_temporary(){ 

	$('#table-proforma-invoice tbody tr').remove();
	//
	    $.ajax({		
		    url: "load_invoice_detail_proforma_temporary/",							
			type: "GET",
			dataType: "JSON",
			    success: function (response) {
					var trHTML = '';
					$.each(response, function (i, item) {
						trHTML += '<tr>';		
						trHTML += '<td>' + item.id_so + "</td>";		
						trHTML += '<td>' + item.so_no + "</td>";
						trHTML += '<td>' + item.so_date + "</td>";										    					
						trHTML += '<td>' + item.buyerno + "</td>";		
						trHTML += '<td align="center">' + item.curr + "</td>";	
						trHTML += '<td align="right">' + item.qty + "</td>";	
						trHTML += '<td align="right">' + item.unit_price + "</td>";	
						trHTML += '<td align="right">' + item.total_price + "</td>";											
						trHTML += '</tr>';

				    });
						$('#table-proforma-invoice').append(trHTML);
                        //Grand Total SO Proforma
						sum_grandtotal_proforma(); 
													
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
			}
	  });  	  	

}

function delete_invoice_detail_proforma_temporary(){ 

	$.ajax({						
		url: "delete_invoice_detail_proforma_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function sum_grandtotal_proforma(){
    //
	$.ajax({		
		url: "sum_grandtotal_proforma/",							
		type: "GET",
		dataType: "JSON",
			success: function (response) {				
				$.each(response, function (i, item) {

					$('[name="prof_grandtotal"]').val(item.grand_total)

				});	
					//							
				},
				error: function (jqXHR, textStatus, errorThrown) {
					alert('Error get data from ajax');
		}
  });  	  
}

function add_data_proforma_invoice(){ 
	let x   = $('[name="prof_shipp"]').val();
	let peb = $('[name="prof_peb"]').val();
       if (x == "") {
          alert("Shipp is required");
          return false;
  		}

		if (x == "Export" && peb == "" ){
			alert("PEB Export is required");
			return false;
		}

		 $no_proforma_invoice = $('[name="prof_inv_number"]').val()		
		 //
		 $('[name="prof_no_inv_mdl"]').val($no_proforma_invoice);
	     $('#modal-simpan-proforma-invoice').modal('show');  		
}

function input_dp_proforma_invoice() { 	
	
	var persen = 0.75;
	var nilai = $('[name="prof_grandtotal"]').val();
	var nilai_input_dp = $('[name="prof_dp"]').val();		
	var grandtotal = nilai.replace(/,/g, '')
	var hasil_persen = grandtotal * persen;
	//
	if (nilai_input_dp > hasil_persen){ 
       alert("Sory total DP lebih besar dari 75% (" + hasil_persen + ") Grand Total SO");
	   $('[name="prof_dp"]').val("");
	} 	
}

function save_proforma_invoice(){ 

	simpan_proforma_invoice_header()	

}

function simpan_proforma_invoice_header() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
			var no_proforma_inv    = $('#prof_inv_number').val();
            var id_customer        = $('#prof_customer').val();
            var shipp              = $('#prof_shipp').val();
            var peb                = $('#prof_peb').val();
            var id_type            = $('#prof_type').val();
            var status             = "POST";                        
			var type_barang        = $('#prof_material_type').val();
			var id_top             = $('#prof_id_top').val();
			var id_bank            = $('#id_bank_prof').val();
			var type_so            = $('#type_so_prof').val();
			var dp                 = $('#prof_dp').val();
			//					
			//Set Now Date Proforma Invoice
			var tgl_proforma_inv   = new Date();		
			var dd = tgl_proforma_inv.getDate();
			var mm = tgl_proforma_inv.getMonth() + 1; 
			var yyyy = tgl_proforma_inv.getFullYear();	
			tgl_proforma_inv = yyyy+'-'+mm+'-'+dd;
			//			
		   	data.push({		
					"no_proforma_invoice": no_proforma_inv,
					"id_customer": id_customer,
					"shipp": shipp,	
					"peb": peb,					
					"id_type": id_type,
					"status": status,
					"tgl_proforma_inv": tgl_proforma_inv,	
					"type_barang": type_barang,		
					"id_top": id_top,	
					"id_bank": id_bank,		
					"type_so": type_so,	
					"dp": dp,												
				})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_header/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}		
					
					//Simpan Proforma Invoice Detail
					simpan_proforma_invoice_detail()	
				    //Hide Modal
				    $('#modal-simpan-proforma-invoice').modal('hide'); 
					//Reload Page
					window.location.reload();
							
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function simpan_proforma_invoice_detail(){ 
	        			
			var msg
			var data = [];		
			var table = document.getElementById("table-proforma-invoice");
			for (var i = 1; i < (table.rows.length); i++) {
				//
				var qty_det = table.rows[i].cells[5].innerHTML; 
				var unit_price_det = table.rows[i].cells[6].innerHTML;
				var total_price_det = table.rows[i].cells[7].innerHTML;
				//				
				qty_det = qty_det.replace(/,/g, '');
				unit_price_det = unit_price_det.replace(/,/g, '');
				total_price_det = total_price_det.replace(/,/g, '');
				//				
				data.push({		
					"no_invoice_proforma": $('#prof_inv_number').val(),
					"so_no": table.rows[i].cells[1].innerHTML,
					"so_date": table.rows[i].cells[2].innerHTML,
					"buyerno": table.rows[i].cells[3].innerHTML,					
					"curr":table.rows[i].cells[4].innerHTML,
					"qty": qty_det,
					"unit_price": unit_price_det,
					"total_price": total_price_det,
					"id_so": table.rows[i].cells[0].innerHTML,			
																			
				})		
			}
															
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_proforma_invoice_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}						
									
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			
}

function cari_proforma_invoice(){ 
	
	$('#table-list-proforma-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_prof_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_prof_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_prof_inv   = "undefined";
			dt_sampai_prof_inv = "undefined";
		});

		var id_customer = $('#list_prof_customer').val();	
							
	$.ajax({		
		url: "cari_proforma_invoice/" + dt_dari_prof_inv + "/" + dt_sampai_prof_inv + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.id + "</td>";
				trHTML += '<td>' + item.no_pi + "</td>";	
				trHTML += '<td>' + item.date_pi + "</td>";
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.shipp + "</td>";	
				trHTML += '<td>' + item.peb + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.no_faktur_pajak + "</td>";	
				trHTML += '<td align="right">' + item.amount + "</td>";	
				trHTML += '<td><button id="faktur_pjk" name="faktur_pjk" type="button" class="btn btn-info btn-sm" onclick="update_faktur_pjk(' + item.id + ')" >Update</button> ' + '' + ' <button id="print_inv_pi" name="print_inv_pi" type="button" class="btn btn-primary btn-sm" onclick="print_proforma_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button></td>';					
				trHTML += '<td><button id="export_to_excel" name="export_to_excel" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_pi(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';					
												
				trHTML += '</tr>';
			});

			$('#table-list-proforma-invoice').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function update_faktur_pjk($id) { 
	
	$('[name="id_inv_prof"]').val($id);	
    $('#modal-update-faktur-pjk').modal('show');  

}

function print_proforma_invoice($id) {
			
	window.open(".../../report_proforma_invoice/" + $id + "/");  	
		
}

function export_to_excel_pi($id){ 
		
	window.open(".../../excel_pi_invoice/" + $id + "/");  

}

function export_list_pi() { 
	var id_customer = $('#list_prof_customer').val();	
	window.open(".../../export_excel_list_pi/" + dt_dari_prof_inv  + "/" + dt_sampai_prof_inv + "/" + "/" + id_customer + "/" ); 
}

//Return Invoice
function get_kode_return_invoice(kode) { 
	$.ajax({
		url: "get_kode_return_invoice/" + kode,		
		type: "GET",
		dataType: "JSON",
		success: function (id) {
            
			$('[name="rtn_inv_number"]').val(id);
						           			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});
}

function add_id_for_return_inv(){ 	
		

	$('#example4 tbody tr').remove();	
	$('#table-return-invoice tbody tr').remove();	
	$('#table-return-invoice-mdl tbody tr').remove();	
	//
	$cust_rtn = $("#rtn_customer :selected").text(); 	
	$idcust_rtn = $('[name="rtn_customer"]').val()	
	//
	$('[name="rtn_custm"]').val($cust_rtn);
	$('[name="rtn_id_custm"]').val($idcust_rtn);

}

function add_data_return_invoice(){ 
	let shipp = $('[name="rtn_shipp"]').val();
	let nrp   = $('[name="rtn_nrp"]').val();
       if (shipp == "") {
          alert("Shipp is required");
		  $("#rtn_shipp").focus();
          return false;
  		}
		//
		if (nrp == "") {
			alert("Nrp is required");
			$("#rtn_nrp").focus();
			return false;
		}

		$no_return_invoice = $('[name="rtn_inv_number"]').val()		
		//
		$('[name="rtn_no_inv_mdl"]').val($no_return_invoice);
	    $('#modal-simpan-return-invoice').modal('show');  		
}

function cari_sjbpb_return(){ 
	
	$('#table-return-invoice-mdl tbody tr').remove();	
	
	//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_rtn_sjbpb   = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_rtn_sjbpb = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_rtn_sjbpb = "undefined";
			dt_sampai_rtn_sjbpb = "undefined";
		});
					
		var id_customer = $('#rtn_id_custm').val();
					
	$.ajax({		
		url: "cari_sjbpb_return/" + dt_dari_rtn_sjbpb + "/" + dt_sampai_rtn_sjbpb + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
							
			var trHTML = '';
			$.each(response, function (i, item) {
				trHTML += '<tr>';				
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_sjbpb_rtn" id="pilih_sjbpb_rtn" class="flat"></td>';									
				trHTML += '<td hidden="hidden">' + item.id + "</td>";
				trHTML += '<td>' + item.bpb_number + "</td>";	
				trHTML += '<td>' + item.sj_number + "</td>";
				trHTML += '<td>' + item.bpbdate+ "</td>";
				trHTML += '<td align="center">' + item.curr + "</td>";
				trHTML += '<td align="right">' + item.qty + "</td>";	
				trHTML += '<td align="right">' + item.price + "</td>";	
				trHTML += '<td align="right">' + item.total_price + "</td>";						
				trHTML += '</tr>';
			});

			$('#table-return-invoice-mdl').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function duplicate_data_sjbpb_return(){ 

	delete_invoice_detail_return_temporary()
	simpan_invoice_detail_return_temporary()
}

function simpan_invoice_detail_return_temporary(){ 
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-return-invoice-mdl input[name='pilih_sjbpb_rtn']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//
				var qty = rows.cells[6].innerHTML; 
				var price = rows.cells[7].innerHTML;
				var total_price = rows.cells[8].innerHTML;
				//
				qty = qty.replace(/,/g, '');
				price = price.replace(/,/g, '');
				total_price = total_price.replace(/,/g, '');
                //
				data.push({												
					"id_bpb": rows.cells[1].innerHTML,	
					"bpb_number": rows.cells[2].innerHTML,						
					"sj_number": rows.cells[3].innerHTML,
					"bpbdate": rows.cells[4].innerHTML,
					"curr": rows.cells[5].innerHTML,
					"qty": qty,
					"price": price,					
					"total_price": total_price,													
				})		 
								
		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_detail_return_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data Invoice Return Temporary
					load_invoice_detail_return_temporary();                   		
					$('#modal-add-sjbpb-return').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function load_invoice_detail_return_temporary(){ 

	$('#table-return-invoice tbody tr').remove();
	    $.ajax({		
		    url: "load_invoice_detail_return_temporary/",							
			type: "GET",
			dataType: "JSON",
			    success: function (response) {
					var trHTML = '';
					$.each(response, function (i, item) {
						trHTML += '<tr>';		
						trHTML += '<td hidden="hidden">' + item.id_bpb + "</td>";		
						trHTML += '<td>' + item.bpb_number + "</td>";
						trHTML += '<td>' + item.sj_number + "</td>";										    					
						trHTML += '<td>' + item.bpbdate + "</td>";		
						trHTML += '<td align="center">' + item.curr + "</td>";	
						trHTML += '<td align="right">' + item.qty + "</td>";	
						trHTML += '<td align="right">' + item.price + "</td>";	
						trHTML += '<td align="right">' + item.total_price + "</td>";											
						trHTML += '</tr>';
				    });
						$('#table-return-invoice').append(trHTML);						
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
			}
	  });  	  	

}

function delete_invoice_detail_return_temporary(){ 

	$.ajax({						
		url: "delete_invoice_detail_return_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function save_return_invoice(){ 
	
	simpan_return_invoice_header()	

}

function simpan_return_invoice_header() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
			var no_return_inv      = $('#rtn_inv_number').val();
            var id_customer        = $('#rtn_customer').val();
            var shipp              = $('#rtn_shipp').val();
			var peb                = $('#rtn_peb').val();
			var id_type            = $('#rtn_type').val();
			var status             = "POST";       
			var nrp                = $('#rtn_nrp').val();
			var asal_inv           = $('#rtn_inv_asal').val();    
			var id_bank            = $('#id_bank_return').val();      
           	//
			//Set Now Date Return Invoice
			var tgl_rtn_inv  = new Date();		
			var dd = tgl_rtn_inv.getDate();
			var mm = tgl_rtn_inv.getMonth() + 1; 
			var yyyy = tgl_rtn_inv.getFullYear();	
			tgl_rtn_inv = yyyy+'-'+mm+'-'+dd;
			//			
		   	data.push({		
					"no_return_invoice": no_return_inv,
					"id_customer": id_customer,
					"shipp": shipp,	
					"peb": peb,					
					"id_type": id_type,
					"status": status,
					"nrp": nrp,
					"no_invoice_asal": asal_inv,	
					"tgl_return_inv": tgl_rtn_inv,		
					"id_bank": id_bank,															
				})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_return_invoice_header/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}		
					
					//Simpan Return Invoice Detail
					simpan_return_invoice_detail()	
				    //Hide Modal
				    $('#modal-simpan-return-invoice').modal('hide'); 
					//Reload Page
					window.location.reload();
							
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function simpan_return_invoice_detail(){ 

	var msg
	var data = [];		
	var table = document.getElementById("table-return-invoice");
	for (var i = 1; i < (table.rows.length); i++) {
		//
		var qty_det         = table.rows[i].cells[5].innerHTML; 
		var price_det       = table.rows[i].cells[6].innerHTML;
		var total_price_det = table.rows[i].cells[7].innerHTML;
		//				
		qty_det             = qty_det.replace(/,/g, '');
		price_det           = price_det.replace(/,/g, '');
		total_price_det     = total_price_det.replace(/,/g, '');
		//				
		data.push({		
			"id_bpb"                : table.rows[i].cells[0].innerHTML,
			"no_invoice_return"     : $('#rtn_inv_number').val(),
			"bpb_number"            : table.rows[i].cells[1].innerHTML,
			"sj_number"			    : table.rows[i].cells[2].innerHTML,
			"bpbdate"				: table.rows[i].cells[3].innerHTML,					
			"curr"					: table.rows[i].cells[4].innerHTML,
			"qty"					: qty_det,
			"price"			        : price_det,
			"total_price"			: total_price_det,				
																	
		})		
	}
													
	var fdata = {
		'data_table': data
	}
	$.ajax({				
		url: "simpan_return_invoice_detail/",
		type: "POST",
		data: fdata,
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Input Detail'
			} else {
				msg = 'Error Input Detail'
			}						
							
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Input Detail' + jqXHR.text
		}
	});

}

function cari_return_invoice() { 
	
	$('#table-list-return-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_rtn_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_rtn_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});		
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_rtn_inv   = "undefined";
			dt_sampai_rtn_inv = "undefined";
		});

		var id_customer = $('#list_rtn_customer').val();					
							
	$.ajax({		
		url: "cari_return_invoice/" + dt_dari_rtn_inv + "/" + dt_sampai_rtn_inv + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 			
			
				trHTML += '<tr>';					
				trHTML += '<td>' + item.id + "</td>";
				trHTML += '<td>' + item.no_return_invoice + "</td>";	
				trHTML += '<td>' + item.tgl_return_inv + "</td>";
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.shipp + "</td>";	
				trHTML += '<td>' + item.peb + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.nrp + "</td>";	
				trHTML += '<td>' + item.no_invoice_asal + "</td>";	
				trHTML += '<td align="right">' + item.amount + "</td>";		
				trHTML += '<td><button id="print_return_inv" name="print_return_inv" type="button" class="btn btn-primary btn-sm" onclick="print_return_invoice(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + '' + '<button id="export_to_excel_return_invoice" name="export_to_excel_return_invoice" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_return_invoice(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button></td>';									
																
				trHTML += '</tr>';
			});

			$('#table-list-return-invoice').append(trHTML);		
			
			// var rowCount = document.getElementById('table-list-return-invoice').rows.length;
			// if (rowCount == 1) { 
			// 	alert("Data Tidak Ditemukan");
			// }			
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function print_return_invoice($id) {
			
	window.open(".../../report_return_invoice/" + $id + "/" );  	
		
}

function export_to_excel_return_invoice($id){ 
			
	window.open(".../../excel_return_invoice/" + $id + "/" );  

}

function export_list_return(){
	var id_customer = $('#list_rtn_customer').val();	
	window.open(".../../export_excel_list_return/" + dt_dari_rtn_inv  + "/" + dt_sampai_rtn_inv + "/" + "/" + id_customer + "/" ); 
	
}

//Debit Note

function save_debitnote() { 
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
			
				//Set Now Date
				var today = new Date();
				var dd = today.getDate();
				var mm = today.getMonth() + 1; 
				var yyyy = today.getFullYear();	
				today = yyyy+'-'+mm+'-'+dd;
				//
				var no_debitnote    = $('#dn_number').val();				
				var id_customer     = $('#dn_customer').val();
				var input_date      = today;
				var doc_date        = $('#doc_date').val();
				var coa             = $('#dn_coa').val();
				var value           = $('#dn_value').val();
				var desc            = $('#dn_desc').val();
				var duedate         = $('#dn_duedate').val(); 
				var status          = "DONE"
				//
				data.push({							
					"no_debitnote" : no_debitnote,
					"id_customer"  : id_customer,	
					"input_date"   : input_date,	
					"doc_date"     : doc_date,
					"coa"          : coa,	
					"value"        : value,		
					"description"  : desc,	
					"duedate"      : duedate,					
					"status"       : status,												
				})							
		
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "save_debitnote/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
										                 		
					$('#modal-debit-note').modal('hide');
					//Reload Page
					location.reload();

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function reload_page_debitnote() { 
	location.reload();	
}

//User Role

function user_change(name) { 
	
	$("input:radio[name=pilih_user]:checked").each(function() {
		$('[name="txt_username"]').val(name);
    });
		
}

function simpan_userrole() { 

	delete_before_userrole();
	save_userrole();

}

function delete_before_userrole() { 

	var namauser = 	$('[name="txt_username"]').val();	
	
	$.ajax({						
		url: "delete_before_userrole/" + namauser + "/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}

		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});

}

function save_userrole() { 
	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-menu input[name='pilih_menu']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//			
				var namauser = 	$('[name="txt_username"]').val();				
				data.push({			
					"user": namauser,										
					"menu_id": rows.cells[3].innerHTML,	
					"base_url": rows.cells[2].innerHTML,		
			})		 
								
		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "save_userrole/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
					// window.location.replace("logout_user_acces");

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
					window.location.reload();
			resolve({
				msg: msg,
			});

		}, 100);
	});
}

function checkallmenu(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}

}

function add_id_for_kwt() {

	$cust = $('[name="customer"]').val()	
	//
	$('[name="custmr"]').val($cust);
	//
	$('#tabelkwt tbody tr').remove();	
	$('#table-inv-kwt tbody tr').remove();
	//
	$('#so_number1').val("");
	//$('#id_sj').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#total1').val("");
	$('#terbilang').val("");
	$('#val_kwt').val("");
	$('#val_kwt1').val("");
	// $('#vat').val("");
	// $('#grandtotal').val("");	
	//
	$('#table-inv-kwt tbody tr').remove();	
	//
	cari_data_inv();
	modal_clear_component();

}

function cari_data_inv() { 

	$('#table-inv-kwt tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_invkwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_invkwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_invkwt   = "undefined";
			dt_sampai_invkwt = "undefined";
		});

		var id_customer = $('#customer').val();

		console.log(dt_dari_invkwt + ' ' + dt_sampai_invkwt);
							
	$.ajax({		
		url: "cari_invoice_kwt/" + dt_dari_invkwt + "/" + dt_sampai_invkwt + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 								
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";	
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.amount1 + "</td>";
				trHTML += '<td><input type="checkbox" name="mdl_cek_kwt" id="mdl_cek_kwt" class="flat"  onclick="modal_sum_total_kwt(value = ' +  item.amount1 + '); modal_get_no_inv(value = ' +  item.no_invoice + ')"></td>';
				
				trHTML += '</tr>';
			});

			$('#table-inv-kwt').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}


function terbilang(angka){

			var bilne=["","Satu","Dua","Tiga","Empat","Lima","Enam","Tujuh","Delapan","Sembilan","Sepuluh","Sebelas"];

			if(angka < 12){

				return bilne[angka];

			}else if(angka < 20){

				return terbilang(angka-10)+" Belas";

			}else if(angka < 100){

				return terbilang(Math.floor(parseInt(angka)/10))+" Puluh "+terbilang(parseInt(angka)%10);

			}else if(angka < 200){

				return "Seratus "+terbilang(parseInt(angka)-100);

			}else if(angka < 1000){

				return terbilang(Math.floor(parseInt(angka)/100))+" Ratus "+terbilang(parseInt(angka)%100);

			}else if(angka < 2000){

				return "Seribu "+terbilang(parseInt(angka)-1000);

			}else if(angka < 1000000){

				return terbilang(Math.floor(parseInt(angka)/1000))+" Ribu "+terbilang(parseInt(angka)%1000);

			}else if(angka < 1000000000){

				return terbilang(Math.floor(parseInt(angka)/1000000))+" Juta "+terbilang(parseInt(angka)%1000000);

			}else if(angka < 1000000000000){

				return terbilang(Math.floor(parseInt(angka)/1000000000))+" Milyar "+terbilang(parseInt(angka)%1000000000);

			}else if(angka < 1000000000000000){

				return terbilang(Math.floor(parseInt(angka)/1000000000000))+" Trilyun "+terbilang(parseInt(angka)%1000000000000);

			}

		}


function formatMoney(amount, decimalCount = 2, decimal = ".", thousands = ",") {
  try {
    decimalCount = Math.abs(decimalCount);
    decimalCount = isNaN(decimalCount) ? 2 : decimalCount;

    const negativeSign = amount < 0 ? "-" : "";

    let i = parseInt(amount = Math.abs(Number(amount) || 0).toFixed(decimalCount)).toString();
    let j = (i.length > 3) ? i.length % 3 : 0;

    return negativeSign + (j ? i.substr(0, j) + thousands : '') + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousands) + (decimalCount ? decimal + Math.abs(amount - i).toFixed(decimalCount).slice(2) : "");
  } catch (e) {
    console.log(e)
  }
}


function modal_sum_total_kwt(){
		
	var input_kwt = document.getElementsByName("mdl_cek_kwt");
  	var total = 0;

	//    	
    for (var i = 0; i < input_kwt.length; i++) {
       		if (input_kwt[i].checked) {				
				total += parseFloat(input_kwt[i].value);

    		}
    type: "POST";					
  	}
	 		
  	document.getElementsByName("val_kwt")[0].value = total;
  	document.getElementsByName("val_kwt1")[0].value = formatMoney(total);
		  	
}

function add_data_kwitansi() { 

	let no_kwt   = $('[name="kwt_number"]').val();
	let ttl          = $('[name="total"]').val();
       if (ttl == "") {
          alert("Please Add Data Invoice!");
		  $("#total").focus();	
          return false;
  		} 
	
	$no_kwt = $('[name="kwt_number"]').val()	

	//
	$('[name="kwt_no"]').val($no_kwt);


	$('#modal-simpan-kwt').modal('show');	
    	
}

function duplicate_data_kwt(){ 
	
	//Tambah Data Potongan Invoice
	var total       = $('[name="val_kwt"]').val();

				var pch=total.split(".");

				var hsldec="";

				if(pch.length>1){

					for(i=0;i<pch.length;i++){

						if(i==pch.length-1){

							hsldec += terbilang(pch[i]);

						}else{

							hsldec += terbilang(pch[i]) + " koma ";

						}

					}

				}else{

					hsldec=terbilang(total);

				}

				$("#out").html(hsldec);

		$('[name="total"]').val(total)
		$('[name="total1"]').val(formatMoney(total));
	$('[name="terbilang"]').val(hsldec + 'Rupiah');


	//Hapus Temporary Table Detail SJ
	//Simpan Table SJ Temp
	delete_kwt_detail_temporary();	
	simpan_kwt_detail_temporary();	

}

function delete_kwt_detail_temporary() { 
			
	$.ajax({						
		url: "delete_kwt_detail_temporary/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}

function simpan_kwt_detail_temporary() {
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			$("#table-inv-kwt input[name='mdl_cek_kwt']:checked").each(function () {
				var rows = $(this).closest("tr")[0];

				// $(this).closest('tr').find("input[name='mdl_disc']").each(function() {				
				// var mdl_disc = this.value	
				
				// $(this).closest('tr').find("input[name='cek_tgl']").each(function() {				
				// 	var tgl_sj = this.value	
																
				data.push({			
					"no_invoice": rows.cells[0].innerHTML,				
					"invoice_date": rows.cells[1].innerHTML,
					"customer": rows.cells[2].innerHTML,	
					"shipp": rows.cells[3].innerHTML,
					"doc_type": rows.cells[4].innerHTML,
					"doc_number": rows.cells[5].innerHTML,
					"type": rows.cells[6].innerHTML,
					"amount": rows.cells[7].innerHTML,			
				})	

			  // });
				
		   //  });
								
		});

			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_kwt_detail_temporary/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SJ Temporary
					load_kwt_detail_temporary();                   		
					$('#modal-add-so').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}


function load_kwt_detail_temporary() { 	
		  	
	$('#table-inv-kwt tbody tr').remove();
	    $.ajax({		
		    url: "load_kwt_detail_temporary/",							
			type: "GET",
			dataType: "JSON",
			    success: function (response) {
					var trHTML = '';
					$.each(response, function (i, item) {
						trHTML += '<tr>';
						trHTML += '<td>' + item.no_invoice + "</td>";
						trHTML += '<td>' + item.invoice_date + "</td>";
						trHTML += '<td>' + item.customer + "</td>";	
						trHTML += '<td>' + item.shipp + "</td>";	
						trHTML += '<td>' + item.doc_type + "</td>";
						trHTML += '<td>' + item.doc_number + "</td>";
						trHTML += '<td>' + item.type + "</td>";	
						trHTML += '<td><input type="text" value="'+ item.tipestyle +'" class="form-control" id="stylein" name="stylein" style="width: 100%; text-align: center;"  autocomplete="off"></td>';
						// trHTML += '<td>' + item.styleno +' '+ item.color + "</td>";		
						// trHTML += '<td><input type="checkbox" name="cek_pilih_sj" id="cek_pilih_sj" class="flat" checked></td>';												
						trHTML += '</tr>';
				    });
						$('#tabelkwt').append(trHTML);						
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
			}
	  });  	  

}

function save_kwitansi() {
	
	simpan_kwt_detail();
	update_status_kwt_inv();
	simpankwitansi();	
	//	
	$('#modal-simpan-kwt').modal('hide');
	
}

function simpan_kwt_detail() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("tabelkwt");
			for (var i = 1; i < (table.rows.length); i++) {

				var style = document.getElementById("tabelkwt").rows[i].cells[7].children[0].value;
				
				data.push({		
					"no_kwitansi": $('#kwt_number').val(),
					"no_invoice": table.rows[i].cells[0].innerHTML,
					"invoice_date": table.rows[i].cells[1].innerHTML,
					"customer": table.rows[i].cells[2].innerHTML,	
					"shipp": table.rows[i].cells[3].innerHTML,					
					"doc_type":table.rows[i].cells[4].innerHTML,
					"doc_number": table.rows[i].cells[5].innerHTML,
					"type": table.rows[i].cells[6].innerHTML,
					"style": style,								
																			
				})		
			}
															
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_kwt_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  
               			
}

function update_status_kwt_inv() { 

			var table = document.getElementById("tabelkwt");
			for (var i = 1; i < (table.rows.length); i++) {	
				//   
				var no_invoice = table.rows[i].cells[0].innerHTML
				var no_kwt = $('[name="kwt_number"]').val()
                //
				var formData = {
					"no_invoice": no_invoice,
					"no_kwt": no_kwt,			
				};
				//
				$.ajax({						
					url: "update_status_kwt_inv/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Bppb'
						} else {
							msg = 'Error Update Bppb'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Bppb' + jqXHR.text
					}
				});   	
				//					
		}				
}

function cari_kwitansi() { 

	$('#table-kwitansi tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_kwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_kwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_kwt   = "undefined";
			dt_sampai_kwt = "undefined";
		});

		var customer = $('#customer').val();	
		console.log(dt_sampai_kwt, dt_dari_kwt);

		
							
	$.ajax({		
		url: "cari_kwitansi/" + dt_dari_kwt + "/" + dt_sampai_kwt + "/" + customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				if(item.status == 'POST' ){				
				trHTML += '<tr>';					
				trHTML += '<td onclick="view_kwt(\'' + item.id + '\',\'' + item.no_kwt + '\')">' + item.no_kwt + "</td>";
				trHTML += '<td>' + item.tgl_kwt + "</td>";	
				trHTML += '<td>' + item.supp + "</td>";
				trHTML += '<td>' + item.curr +' '+ item.total + "</td>";
				trHTML += '<td>' + item.bilang + "</td>";
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType3(\'' + item.supp + '\',\'' + item.no_kwt + '\',\'' + item.total + '\',\'' + item.bilang + '\')">Update</button> ' + '' 
				+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_kwitansi(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_kwt(\'' + item.no_kwt + '\', \'' + item.status + '\')">Cancel</button></td> </td>';
				
				trHTML += '</tr>';
			}else{
				trHTML += '<tr>';					
				trHTML += '<td onclick="view_kwt(\'' + item.id + '\',\'' + item.no_kwt + '\')">' + item.no_kwt + "</td>";
				trHTML += '<td>' + item.tgl_kwt + "</td>";	
				trHTML += '<td>' + item.supp + "</td>";
				trHTML += '<td>' + item.curr +' '+ item.total + "</td>";
				trHTML += '<td>' + item.bilang + "</td>";
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td style="text-align: center;"><i><b>Canceled</b></i></td>';
				
				trHTML += '</tr>';
			}
			});

			$('#table-kwitansi').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function cancel_kwt(no_kwt, status){ 

	let status_inv  = status;		
    
	$('#txt_cancel_book').val(no_kwt);
	$('#id_kwitansi').val(no_kwt);
	// $('#id_bppb').val(shipp_number);
	$('#modal-cancel-kwt').modal('show');  

}

function print_kwitansi(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_kwitansi/" + id + "/" );  	
		
}

function getType3(supp, no_kwt, total, bilang) {
	

	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "getType3/" + no_kwt,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="no_kwt"]').val(no_kwt);
			$('[name="amount"]').val(total);
			$('[name="terbilang"]').val(bilang);
			$('#update-kwt').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	  });
	}

function view_kwt(id, kwt){ 
	
    var no_kwt  = id;

	$('#txt_view').val(kwt);
	// $('#id_kwitansi').val(no_kwt);
	// $('#id_bppb').val(shipp_number);
	cari_view_kwitansi(no_kwt);
	// $('#modal-view-kwt').modal('show');  

}

function cari_view_kwitansi(no_kwt) { 

	$('#table-view-kwt tbody tr').remove();	
		//Date range picker		
							
	$.ajax({		
		url: "cari_view_kwitansi/" + no_kwt + "/" ,					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 								
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.invoice_date + "</td>";	
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.style + "</td>";
				trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType4(\'' + item.id_detail + '\',\'' + item.no_invoice + '\',\'' + item.style + '\')">Update</button> ';
				trHTML += '</tr>';
				// trHTML += '<td>' + item.curr +' '+ item.total + "</td>";
			
			});


			$('#table-view-kwt').append(trHTML);	
			$('#modal-view-kwt').modal('show');			
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function getType4(id, no_inv, style) {
	

	$('.form-group').removeClass('has-error'); // clear error class
	$('.help-block').empty(); // clear error string
	//Ajax Load data from ajax
	$.ajax({
		url: "getType3/" + id,
		type: "GET",
		dataType: "JSON",
		success: function (data) {
			
			$('[name="id"]').val(id);
			$('[name="no_inv"]').val(no_inv);
			$('[name="style"]').val(style);
			$('#update-inv-style').modal('show'); // show bootstrap modal when complete loaded
			//
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	  });
	}


	 async function update_style2(){
   await update_style();
   console.log("hasil");
   update_style3();
}

function update_style3() {
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg = ''
	var no_kwt  	= $('[name="txt_view"]').val();

	$('#update-inv-style').modal('hide');
	cari_view_kwitansi(no_kwt);

	resolve({
				msg: msg,
			});

		}, 2000);
	});
	
}


function update_style() { 

	// return new Promise(resolve => {		
	// 	setTimeout(() => {
	// 		var msg
			
	var id  	= $('[name="id"]').val()
	var no_inv  = $('[name="no_inv"]').val()
	var style  	= $('[name="style"]').val()
	//
	var formData = {
		"id"	: id,
		"no_inv": no_inv,
		"style"	: style,							
	};
	
	$.ajax({						
		url: "update_style/",		
		type: "POST",	
		data: formData,			
		dataType: "JSON",
		success: function (data) {		
					
			if (data.status) //if success close modal and reload ajax table
			{
				msg = ''
			} else {
				msg = ''
			}

			$('#update-inv-style').modal('hide');
			// cari_view_kwitansi();                   		
		},
		error: function (jqXHR, textStatus, errorThrown) {
			//alert('Error Update Book Invoice ' + jqXHR.text)
		}
	});

	// resolve({
	// 			msg: msg,
	// 		});

	// 	}, 2000);
	// });

}

function modal_input_price(){ 
	var table = document.getElementById("table-sj");
	var tota = 0;
	var totall = 0;
			for (var i = 1; i < (table.rows.length); i++) {

	var qty = document.getElementById("table-sj").rows[i].cells[13].children[0].value;
	var price = document.getElementById("table-sj").rows[i].cells[14].children[0].value;
	var dis = $('[name="diskon"]').val();
	tota += parseFloat(qty * price);
	totall = parseFloat(tota - dis);

	document.getElementById("table-sj").rows[i].cells[16].children[0].value = (qty * price).toFixed(2);
	document.getElementsByName("total_h")[0].value = tota.toFixed(2);
	document.getElementsByName("amount")[0].value = tota.toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney(tota.toFixed(2));
	document.getElementsByName("twot")[0].value = totall.toFixed(2);
	document.getElementsByName("grandtotal")[0].value = totall.toFixed(2);

}
}

function modal_input_disk(){ 
	var table = document.getElementById("table-sj");
	var tota = $('[name="total_h"]').val(); 
	var diskon = 0;
	var tota_l = 0;
			for (var i = 1; i < (table.rows.length); i++) {

	var disk = document.getElementById("table-sj").rows[i].cells[15].children[0].value;
	var total = document.getElementById("table-sj").rows[i].cells[16].children[0].value;
	diskon += parseFloat(disk * total / 100);
	tota_l = tota - diskon;


	document.getElementsByName("diskon")[0].value = diskon.toFixed(2);
	document.getElementsByName("twot")[0].value = tota_l.toFixed(2);
	document.getElementsByName("grandtotal")[0].value = tota_l.toFixed(2);
	document.getElementsByName("amount")[0].value = tota_l.toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney(tota_l.toFixed(2));
	
}
}

function modal_input_disk(){ 
	var table = document.getElementById("table-sj");
	var tota = $('[name="total_h"]').val(); 
	var diskon = 0;
	var tota_l = 0;
			for (var i = 1; i < (table.rows.length); i++) {

	var disk = document.getElementById("table-sj").rows[i].cells[15].children[0].value;
	var total = document.getElementById("table-sj").rows[i].cells[16].children[0].value;
	diskon += parseFloat(disk * total / 100);
	tota_l = tota - diskon;


	document.getElementsByName("diskon")[0].value = diskon.toFixed(2);
	document.getElementsByName("twot")[0].value = tota_l.toFixed(2);
	document.getElementsByName("grandtotal")[0].value = tota_l.toFixed(2);
	document.getElementsByName("amount")[0].value = tota_l.toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney(tota_l.toFixed(2));
	
}
}

function modal_inputdp(){ 
	var total = $('[name="total_h"]').val();
	var discount = $('[name="diskon"]').val();
	var dp = $('[name="dp"]').val(); 
	document.getElementsByName("twot")[0].value = (total - discount - dp).toFixed(2);
	document.getElementsByName("grandtotal")[0].value = (total - discount - dp).toFixed(2);
	document.getElementsByName("amount")[0].value = (total - discount - dp).toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney((total - discount - dp).toFixed(2));
}

function modal_inputretur() { 
	var total = $('[name="total_h"]').val();
	var discount = $('[name="diskon"]').val();
	var dp = $('[name="dp"]').val();  
	var retur = $('[name="return"]').val(); 
	document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur).toFixed(2);
	document.getElementsByName("twot")[0].value = (total- discount-dp-retur).toFixed(2);
	document.getElementsByName("amount")[0].value = (total- discount-dp-retur).toFixed(2);
	document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur).toFixed(2));
}

function modal_inputvat(){ 

	var vat = 0.1; 
    //
	if ($('[name="checkvat"]').is(':checked')) {			
			var total = $('[name="total_h"]').val();
			var discount = $('[name="diskon"]').val();
			var dp = $('[name="dp"]').val();  
			var retur = $('[name="return"]').val(); 	
			var twot = (total- discount-dp-retur).toFixed(2) * vat;
			document.getElementsByName("vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur+twot).toFixed(2);	
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur +twot).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur +twot).toFixed(2));
	} else { 		
		 	var total = $('[name="total_h"]').val();
			var discount = $('[name="diskon"]').val();
			var dp = $('[name="dp"]').val();  
			var retur = $('[name="return"]').val();
			document.getElementsByName("vat")[0].value = "0.00";
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur).toFixed(2));
	}
}

function modal_inputvat_baru(){ 

	var vat = 0.11; 
    //
	if ($('[name="checkvat_baru"]').is(':checked')) {			
			var total = $('[name="total_h"]').val();
			var discount = $('[name="diskon"]').val();
			var dp = $('[name="dp"]').val();  
			var retur = $('[name="return"]').val(); 	
			var twot = (total- discount-dp-retur).toFixed(2) * vat;
			document.getElementsByName("vat")[0].value = (twot).toFixed(2);
			//document.getElementsByName("mdl_grandtotal")[0].value = (total_sj- discount-dp-retur-twot).toFixed(2);	
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur+twot).toFixed(2);	
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur +twot).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur +twot).toFixed(2));
	} else { 		
		 	var total = $('[name="total_h"]').val();
			var discount = $('[name="diskon"]').val();
			var dp = $('[name="dp"]').val();  
			var retur = $('[name="return"]').val();
			document.getElementsByName("vat")[0].value = "0.00";
			document.getElementsByName("grandtotal")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount")[0].value = (total- discount-dp-retur).toFixed(2);
			document.getElementsByName("amount_h")[0].value =formatMoney((total- discount-dp-retur).toFixed(2));
	}
}


function add_data_invoice_nb() { 

	// let no_invoice   = $('[name="inv_number1"]').val();
	// let top          = $('[name="top"]').val();
 //       if (no_invoice == "") {
 //          alert("Invoice Number is required");
	// 	  $("#inv_number1").focus();	
 //          return false;
 //  		}

	// 	if (top == "") {
	// 	  alert("Top is required");
	// 	  $("#top").focus();	
	// 	  return false;
	// 	}  
	
	$no_invoice = $('[name="inv_num"]').val()	
	$id_inv     = $('[name="id_num"]').val()	
	// $pph     = $('[name="pph"]').val()
	//
	$('[name="no_inv_post"]').val($no_invoice);
	$('[name="id_num_post"]').val($id_inv);
	// $('[name="pph_post"]').val($pph);

	$('#modal-simpan-invoice_nb').modal('show')	
    	
}

function save_invoice_nb() {
	
	simpan_invoice_nb_detail();
	simpan_invoice_nb();
	simpan_invoice_nb_pot();	
	//	
	$('#modal-simpan-invoice_nb').modal('hide');
	
}

function simpan_invoice_nb() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
			   		var no_inv 					= $('#inv_num').val();
            var inv_date        = $('#invoice_date').val();
            var customer        = $('#cust').val();
            var top_type        = $('#top').val();
            var top           	= $('#top_time').val();
            var shipp           = $('#shipp').val();
            var doc_type        = $('#doc_type').val();
            var doc_number     	= $('#doc_number').val();
            var type           	= $('#type').val();
            var amount          = $('#amount').val();
            var bank            = $('#id_bank').val();
            var pph     				= $('#pph').val();
            var type_so     		= $('#type_so').val();
            var status      		= "POST";
            var create_date			= $('#date_inv').val();
			//			
		   	data.push({		
					"no_inv": no_inv,
					"inv_date": inv_date,
					"customer": customer,	
					"top_type": top_type,					
					"top": top,
					"shipp": shipp,
					"doc_type": doc_type,	
					"doc_number": doc_number,	
					"type": type,
					"amount": amount,
					"bank": bank,
					"pph": pph,
					"type_so" : type_so,
					"status": status,
					"create_date": create_date,															
				})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_nb/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					// delete_invoice_detail_temporary();
					// // Print Preview Invoice
					// let id_invoice = $('[name="id_num"]').val();
					// print_invoice_nb(id_invoice);
                    // Reload Page
					window.location.href = window.location.href;

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}



function cari_invoice_nb() { 

	$('#table-invoice-nb tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_inv   = "undefined";
			dt_sampai_inv = "undefined";
		});

		var id_customer = $('#customer').val();	

		
							
	$.ajax({		
		url: "cari_invoice_nb/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				if(item.status == 'POST' ){				
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.tgl_inv + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td align="right">' + item.amount + "</td>";
				trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail_nb(' + item.id + ')" >Cek Detail</button> ' + '' 
				+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice_nb(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				+ '<button id="export_to_excel_invoice_nb" name="export_to_excel_invoice_nb" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice_nb(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> ' + ''				
				+ ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_invoice_nb(\'' + item.id + '\',\'' + item.no_invoice + '\',\'' + item.status + '\')">Cancel</button></td> </td>';
				
				trHTML += '</tr>';
			}else{
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.tgl_inv + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";
				trHTML += '<td align="right">' + item.amount + "</td>";
				trHTML += '<td><button id="inv_detail" name="inv_detail" type="button" class="btn btn-info btn-sm" onclick="cari_inv_detail_nb(' + item.id + ')" >Cek Detail</button> ' + '' 
				+ ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_invoice_nb(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				+ '<button id="export_to_excel_invoice_nb" name="export_to_excel_invoice_nb" type="button" class="btn btn-primary btn-sm" onclick="export_to_excel_invoice_nb(' + item.id + ')"><i class="fa fa-download"></i> Export To Xls</button> </td>';
				
				trHTML += '</tr>';
			}
			});

			$('#table-invoice-nb').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function cari_inv_detail_nb(id_inv) { 
	
	$('#table-inv-detail-nb tbody tr').remove();		
	$('#modal-inv-detail-nb').modal('show');
	$.ajax({		
		url: "cari_inv_detail_nb/" + id_inv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
							
			var trHTML = '';
			$.each(response, function (i, item) { 			
				trHTML += '<tr>';										
				trHTML += '<td>' + item.so_number + "</td>";
				trHTML += '<td>' + item.bppb_Number + "</td>";	
				trHTML += '<td>' + item.shipp_number + "</td>";
				trHTML += '<td>' + item.ws + "</td>";
				trHTML += '<td>' + item.styleno + "</td>";
				trHTML += '<td>' + item.product_group + "</td>";
				trHTML += '<td>' + item.product_item + "</td>";
				trHTML += '<td>' + item.color + "</td>";
				trHTML += '<td>' + item.size + "</td>";
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + item.uom + "</td>";
				trHTML += '<td>' + item.qty + "</td>";
				trHTML += '<td>' + item.unit_price + "</td>";	
				trHTML += '<td>' + item.disc + "</td>";				
				trHTML += '<td align="right">' + item.total_price + "</td>";				
				trHTML += '</tr>';
                //
				$('#inv_number_list-nb').val(item.no_invoice)
				//				
			});
			
			$('#table-inv-detail-nb').append(trHTML);
			
			cari_inv_nb_pot(id_inv);						
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
	
}


function export_to_excel_invoice_nb($id) { 			
	window.open(".../../export_excel_invoice_nb/" + $id + "/");  
}

function cancel_invoice_nb(id, no_invoice, status){ 

	let status_inv  = status;		
    
	$('#txt_cancel_book').val(no_invoice);
	$('#id_book_inv').val(no_invoice);
	$('#modal-cancel-inv-nb').modal('show');  

}

function export_list_invoice_nb() { 		
	var id_customer = $('#customer').val();	
	window.open(".../../export_excel_list_invoice_nb/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/" ); 
}


function simpan_invoice_nb_pot() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
			   		var no_inv 					= $('#inv_num').val();
            var total           = $('#total_h').val();
            var diskon        	= $('#diskon').val();
            var dp              = $('#dp').val();
            var retur           = $('#return').val();
            var twot            = $('#twot').val();
            var vat             = $('#vat').val();
            var grand_total     = $('#grandtotal').val();
			//			
		   	data.push({		
					"no_inv": no_inv,
					"total": total,
					"diskon": diskon,	
					"dp": dp,					
					"retur": retur,
					"twot": twot,
					"vat": vat,	
					"grand_total": grand_total,																
				})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpan_invoice_nb_pot/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					// delete_invoice_detail_temporary();
					// // Print Preview Invoice
					let id_invoice = $('[name="id_num_post"]').val();
					print_invoice_nb(id_invoice);
                    // Reload Page
					window.location.href = window.location.href;

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

function print_invoice_nb(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_invoice4/" + id + "/" );  	
		
}

function simpan_invoice_nb_detail() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {

				var id_bppb = document.getElementById("table-sj").rows[i].cells[0].children[0].value;
				var no_so = document.getElementById("table-sj").rows[i].cells[1].children[0].value;
				var no_bppb = document.getElementById("table-sj").rows[i].cells[2].children[0].value;
				var sj_date = document.getElementById("table-sj").rows[i].cells[3].children[0].value;
				var no_shipp = document.getElementById("table-sj").rows[i].cells[4].children[0].value;
				var no_ws = document.getElementById("table-sj").rows[i].cells[5].children[0].value;
				var no_style = document.getElementById("table-sj").rows[i].cells[6].children[0].value;
				var prod_grup = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
				var prod_item  = document.getElementById("table-sj").rows[i].cells[8].children[0].value;
				var color = document.getElementById("table-sj").rows[i].cells[9].children[0].value;
				var size = document.getElementById("table-sj").rows[i].cells[10].children[0].value;
				var curr = document.getElementById("table-sj").rows[i].cells[11].children[0].value;
				var uom = document.getElementById("table-sj").rows[i].cells[12].children[0].value;
				var qty = document.getElementById("table-sj").rows[i].cells[13].children[0].value;
				var unit_price = document.getElementById("table-sj").rows[i].cells[14].children[0].value;
				var diskon = document.getElementById("table-sj").rows[i].cells[15].children[0].value;
				var total = document.getElementById("table-sj").rows[i].cells[16].children[0].value;
				var status      = "POST";
				
				data.push({		
					"no_inv": $('#inv_num').val(),
					"id_bppb": id_bppb,
					"no_so": no_so,	
					"no_bppb": no_bppb,					
					"sj_date":sj_date,
					"no_shipp": no_shipp,
					"no_ws": no_ws,
					"no_style": no_style,
					"prod_grup": prod_grup,
					"prod_item": prod_item,
					"color": color,
					"size": size,	
					"curr": curr,					
					"uom":uom,
					"qty": qty,
					"unit_price": unit_price,
					"diskon": diskon,
					"total": total,
					"status": status,								
																			
				})		
			}
															
			var fdata = {
				'data_table': data
			}

			$.ajax({				
				url: "simpan_invoice_nb_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  
               			
}

function input_rate(){ 
	var rat = $('[name="rate"]').val();
	document.getElementsByName("pl_rate")[0].value = formatMoney(rat);
}

function modal_input_amt(){ 
	var table = document.getElementById("table-sj");
	var tota = 0;
	var totall = 0;
			for (var i = 1; i < (table.rows.length); i++) {

	var price = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
	var outstan = $('[name="am_awal"]').val();
	tota += parseFloat(price);
	totall = parseFloat(outstan - tota);

	document.getElementsByName("out_alok")[0].value = totall.toFixed(2);

}
}

function input_awal(){ 
	var table = document.getElementById("table-sj");
	var tota = 0;
	var totall = 0;
	var cr = $('[name="currn"]').val();
	if (cr == 'USD') {
		var rate = $('[name="rate"]').val();
	}else{
		var rate = $('[name="rate_h"]').val();
	}
	var amt = $('[name="am_awal"]').val();
			for (var i = 1; i < (table.rows.length); i++) {

	var price = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
	var outstan = $('[name="am_awal"]').val();
	tota += parseFloat(price);
	totall = parseFloat(outstan - tota);

	document.getElementsByName("out_alok")[0].value = totall.toFixed(2);

}
	document.getElementsByName("am_akhir")[0].value = formatMoney(rate * amt);
	document.getElementsByName("pl_awal")[0].value = formatMoney(amt);
	document.getElementsByName("pl_akhir")[0].value = (rate * amt);
}


function add_id_() {

	$cust = $('[name="customer"]').val()
	var cr = $('[name="currn"]').val();
	var paywith = $('[name="pay_type"]').val();
	$pwith = paywith;

	if (cr == 'USD') {
		$rate = $('[name="rate"]').val();
	}else{
		$rate = $('[name="rate_h"]').val();
	}

	if (paywith == 'USD') {
		$alo = $('[name="am_awal"]').val();
	}else{
		$alo = $('[name="pl_akhir"]').val()
	}

	console.log(paywith);

	//
	$('[name="custmr"]').val($cust);
	$('[name="rates"]').val($rate);
	$('[name="pwith"]').val($pwith);
	$('[name="val_alo"]').val($alo);
	$('[name="val_alo1"]').val(formatMoney($alo));
	//
	$('#tabelkwt tbody tr').remove();	
	//
	$('#so_number1').val("");
	//$('#id_sj').val("");
	//Clear Value : Total, Discount, Down Payment, Return, Total With Out Tax, VAT, Grand Total
	$('#total').val("");
	$('#total1').val("");
	$('#terbilang').val("");
	$('#val_kwt').val("");
	$('#val_kwt1').val("");
	// $('#vat').val("");
	// $('#grandtotal').val("");	
	//
	//
	cari_data_inv();
	modal_clear_component();

}

function simpan_data_alokasi() { 

	let doc_num   = $('[name="doc_number"]').val();
	let bank      = $('[name="bank"]').val();
	let account   = $('[name="acc"]').val();
	let outstand   = $('[name="out_alok"]').val();
       if (doc_num == "") {
          alert("Document Number is required");
		  $("#doc_number").focus();	
          return false;
  		}

		if (bank == "") {
		  alert("Bank is required");
		  $("#bank").focus();	
		  return false;
		}

		if (account == "") {
		  alert("Account is required");
		  $("#acc").focus();	
		  return false;
		}  
	
	$no_invoice = $('[name="alk_number"]').val()	

	$('[name="no_alokasi"]').val($no_invoice);
	if (outstand == 0) {
	$('#modal-simpan-alokasi').modal('show')	
}else{
	alert("outstanding alokasi harus nol");
}
    	
}

function cari_data_invoic() { 

	$('#table-inv-alok tbody tr').remove();	
		//Date range picker
		$('input[name="cobacoba"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});

		$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_invkwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_invkwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="cobacoba"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_invkwt   = "undefined";
			dt_sampai_invkwt = "undefined";
		});

		var id_customer = $('#custmr').val();
		var rate = $('#rates').val();
		var pwith = $('#pwith').val();

		console.log(dt_dari_invkwt + ' ' + dt_sampai_invkwt + ' ' + rate + ' ' + pwith);
							
	$.ajax({		
		url: "cari_invoice_alo/" + dt_dari_invkwt + "/" + dt_sampai_invkwt + "/" + id_customer + "/" + rate + "/" + pwith + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 								
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.duedate + "</td>";	
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td style="display:none;">' + item.amount1 + "</td>";
				trHTML += '<td style="display:none;">' + item.amountrate + "</td>";
				trHTML += '<td>' + item.amount + "</td>";
				trHTML += '<td>' + item.amountrate1 + "</td>";		
				trHTML += '<td><input type="text" class="form-control" id="mdl_amo" name="mdl_amo" style="width: 80%; text-align: right" oninput="modal_input_amo(value)" readonly autocomplete="off"></td>';
				trHTML += '<td><input type="checkbox" name="mdl_cek_kwt" id="mdl_cek_kwt" class="flat"  onclick="modal_sum_total_alo(value = ' +  item.amount1 + '); modal_get_amount(value = ' +  item.amount1 + ')"></td>';
				
				trHTML += '</tr>';
			});

			$('#table-inv-alok').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function modal_sum_total_alo(){
		
	var input_kwt = document.getElementsByName("mdl_cek_kwt");
	var hanya_baca = document.getElementsByName("mdl_amo");	
  	var total = 0;

	//    	
    for (var i = 0; i < input_kwt.length; i++) {
    	for (var i = 0; i < hanya_baca.length;  i++){
       		if (input_kwt[i].checked) {
       		hanya_baca[i].readOnly = false;				
				total += parseFloat(input_kwt[i].value);

    		}else {				
				hanya_baca[i].readOnly = true;
				hanya_baca[i].value = '';
				// modal_input_amo();
					
			}
    type: "POST";					
  	}
  }
	 		
  	// document.getElementsByName("val_kwt")[0].value = total;
  	// document.getElementsByName("val_kwt1")[0].value = formatMoney(total);
		  	
}

function modal_get_amount(){
		
		
	var input_kwt = document.getElementsByName("mdl_cek_kwt");
  	var total = 0;
  	var totalas = 0;

	//    	
    for (var i = 0; i < input_kwt.length; i++) {
       		if (input_kwt[i].checked) {				
				total = parseFloat(input_kwt[i].value);
				totalas += parseFloat(input_kwt[i].value);

  	document.getElementsByName("mdl_amo")[i].value = total;		  	
    		}
    type: "POST";					
  	}
	 		

	 document.getElementsByName("val_kwt")[0].value = totalas;
  	document.getElementsByName("val_kwt1")[0].value = formatMoney(totalas);
		  	
}


function modal_input_amo(value){ 

		
	var input = document.getElementsByName("mdl_cek_kwt");
	var pwith = $('#pwith').val();
  	var total = 0;	
	//
	var table = document.getElementById("table-inv-alok");
	var arr = document.getElementsByName('mdl_amo');
    var tot = 0;
    var amou = 0;
    for(var i = 0; i < arr.length; i++){
		for (var i = 0; i < input.length; i++) {
    for (var i = 0; i + 1 < table.rows.length; i++) {
    	if (pwith == "USD") {
    		if (input[i].checked) {
				   total = parseFloat(input[i].value);
				   amou = table.rows[i + 1].cells[4].innerHTML;
				   if(parseFloat(arr[i].value) > table.rows[i + 1].cells[4].innerHTML){
            	   	arr[i].value = table.rows[i + 1].cells[4].innerHTML;
            	   	 tot += parseFloat(table.rows[i + 1].cells[4].innerHTML);
            	   }else{
            	   arr[i].value = arr[i].value;	 
            	   tot += parseFloat(arr[i].value);
            	   } 
			 } 
    	}
    		else{
			if (input[i].checked) {
				   total = parseFloat(input[i].value);
				   amou = table.rows[i + 1].cells[5].innerHTML;
				   if(parseFloat(arr[i].value) > table.rows[i + 1].cells[5].innerHTML){
            	   	arr[i].value = table.rows[i + 1].cells[5].innerHTML;
            	   	 tot += parseFloat(table.rows[i + 1].cells[5].innerHTML);
            	   }else{
            	   arr[i].value = arr[i].value;	 
            	   tot += parseFloat(arr[i].value);
            	   } 
			 } 
			}
		}	        
    }	
    }	

	 document.getElementsByName("val_kwt")[0].value = tot;
  	document.getElementsByName("val_kwt1")[0].value = formatMoney(tot);  			
}

function duplicate_data_alo(){ 

	var saldo    = $('[name="val_alo"]').val();
  var pay      = $('[name="val_kwt"]').val();
  var total = saldo - pay;
  console.log(saldo);
  console.log(pay);
  console.log(total);
  $('[name="out_alok"]').val(total);
  $('[name="out_alok_h"]').val(total);
 	delete_invoice_detail_alo();
	simpan_invoice_detail_alo();

		
}


function delete_invoice_detail_alo(){ 

	$.ajax({						
		url: "delete_invoice_detail_alo/",
		type: "GET",				
		dataType: "JSON",
		success: function (data) {
			
			if (data.status) //if success close modal and reload ajax table
			{
				msg = 'Success Delete Table Temporary'			     
			} else {
				msg = 'Error Delete Table Temporary'				
			}
		},
		error: function (jqXHR, textStatus, errorThrown) {
			msg = 'Error Delete Table Temporary' + jqXHR.text			
		}
	});
	
}


function simpan_invoice_detail_alo(){
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];	
			
			$("#table-inv-alok input[name='mdl_cek_kwt']:checked").each(function () {
				var rows = $(this).closest("tr")[0];
				//
				$(this).closest('tr').find("input[name='mdl_amo']").each(function() {				
				var amnt = this.value	
                //
				data.push({							
					//"id_invoice_proforma": rows.cells[0].innerHTML,
					"ref_number": rows.cells[0].innerHTML,	
					"ref_date": rows.cells[1].innerHTML,						
					"due_date": rows.cells[2].innerHTML,
					"curr": rows.cells[3].innerHTML,
					"total": rows.cells[4].innerHTML,
					"eqp_idr": rows.cells[5].innerHTML,					
					"amount": amnt,								
				})	
				});		 
								
		});

			var fdata = {
				'data_table': data
			}
			console.log(fdata);
			$.ajax({				
				url: "simpan_invoice_detail_alo/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}

					//Load Data SO Proforma Temporary
					load_invoice_detail_alo();                   		
					$('#modal-add-so').modal('hide');

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});
}


function load_invoice_detail_alo(){ 

	$('#table-sj tbody tr').remove();


	var coa = "<select class='form-control select2bs4' name='coa' id='coa' style='width: 300px'> <option value='-' > - </option> <option value = '1.01.01'> 1.01.01 KAS KECIL PABRIK </option><option value = '1.01.02'> 1.01.02 KAS KECIL KANTOR </option><option value = '1.01.03'> 1.01.03 KAS BESAR </option><option value = '1.10.01'> 1.10.01 BCA 008-997-1979 </option><option value = '1.10.02'> 1.10.02 BCA 008-998-1982 </option><option value = '1.10.11'> 1.10.11 BNI 442-244-2000 </option><option value = '1.20.01'> 1.20.01 OBLIGASI </option><option value = '1.30.01'> 1.30.01 PIUTANG USAHA PIHAK KETIGA - LOKAL </option><option value = '1.30.02'> 1.30.02 PIUTANG USAHA PIHAK KETIGA - EKSPOR </option><option value = '1.31.01'> 1.31.01 PIUTANG USAHA GIRO MUNDUR PIHAK KETIGA  - LOKAL </option><option value = '1.31.02'> 1.31.02 PIUTANG USAHA GIRO MUNDUR PIHAK KETIGA  - EKSPOR </option><option value = '1.32.01'> 1.32.01 PIUTANG USAHA PIHAK BERELASI - LOKAL </option><option value = '1.32.02'> 1.32.02 PIUTANG USAHA PIHAK BERELASI - EKSPOR </option><option value = '1.33.01'> 1.33.01 PIUTANG USAHA GIRO MUNDUR PIHAK BERELASI - LOKAL </option><option value = '1.33.02'> 1.33.02 PIUTANG USAHA GIRO MUNDUR PIHAK BERELASI - EKSPOR </option><option value = '1.34.01'> 1.34.01 PIUTANG LAIN-LAIN - BAHAN BAKU/BAHAN PEMBANTU </option><option value = '1.34.02'> 1.34.02 PIUTANG LAIN-LAIN - MESIN </option><option value = '1.34.03'> 1.34.03 PIUTANG LAIN-LAIN - SPAREPARTS </option><option value = '1.34.51'> 1.34.51 PIUTANG LAIN-LAIN - KARYAWAN </option><option value = '1.34.61'> 1.34.61 PIUTANG LAIN-LAIN - PPH 23 </option><option value = '1.34.99'> 1.34.99 PIUTANG LAIN-LAIN </option><option value = '1.35.01'> 1.35.01 PIUTANG LAIN-LAIN - BAHAN BAKU/BAHAN PEMBANTU </option><option value = '1.35.02'> 1.35.02 PIUTANG LAIN-LAIN - MESIN </option><option value = '1.35.03'> 1.35.03 PIUTANG LAIN-LAIN - SPAREPARTS </option><option value = '1.35.51'> 1.35.51 PIUTANG LAIN-LAIN - DIREKSI </option><option value = '1.35.99'> 1.35.99 PIUTANG LAIN-LAIN </option><option value = '1.36.01'> 1.36.01 PERSEDIAAN CHEMICAL </option><option value = '1.36.11'> 1.36.11 PERSEDIAAN BENANG GREY </option><option value = '1.36.12'> 1.36.12 PERSEDIAAN BENANG WARNA </option><option value = '1.36.21'> 1.36.21 PERSEDIAAN KAIN GREY </option><option value = '1.36.22'> 1.36.22 PERSEDIAAN KAIN MATANG </option><option value = '1.37.01'> 1.37.01 PERSEDIAAN CHEMICAL </option><option value = '1.37.11'> 1.37.11 PERSEDIAAN BENANG GREY </option><option value = '1.37.12'> 1.37.12 PERSEDIAAN BENANG WARNA </option><option value = '1.37.21'> 1.37.21 PERSEDIAAN KAIN GREY </option><option value = '1.37.22'> 1.37.22 PERSEDIAAN KAIN MATANG </option><option value = '1.38.01'> 1.38.01 PERSEDIAAN DUS </option><option value = '1.38.11'> 1.38.11 PERSEDIAAN PLASTIK </option><option value = '1.38.21'> 1.38.21 PERSEDIAAN CONES & KLONGSONG </option><option value = '1.38.31'> 1.38.31 PERSEDIAAN LABEL </option><option value = '1.38.41'> 1.38.41 PERSEDIAAN AKSESORIS GARMENT </option><option value = '1.38.99'> 1.38.99 PERSEDIAAN LAIN-LAIN </option><option value = '1.39.01'> 1.39.01 PERSEDIAAN DUS </option><option value = '1.39.11'> 1.39.11 PERSEDIAAN PLASTIK </option><option value = '1.39.21'> 1.39.21 PERSEDIAAN CONES & KLONGSONG </option><option value = '1.39.31'> 1.39.31 PERSEDIAAN LABEL </option><option value = '1.39.41'> 1.39.41 PERSEDIAAN AKSESORIS GARMENT </option><option value = '1.39.99'> 1.39.99 PERSEDIAAN LAIN-LAIN </option><option value = '1.40.01'> 1.40.01 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - FOB </option><option value = '1.40.02'> 1.40.02 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - FOB </option><option value = '1.40.03'> 1.40.03 PERSEDIAAN BARANG DALAM PROSES - FINISHING - FOB </option><option value = '1.40.11'> 1.40.11 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - CMT </option><option value = '1.40.12'> 1.40.12 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - CMT </option><option value = '1.40.13'> 1.40.13 PERSEDIAAN BARANG DALAM PROSES - FINISHING - CMT </option><option value = '1.40.21'> 1.40.21 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - FOB </option><option value = '1.40.31'> 1.40.31 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - CMT </option><option value = '1.40.41'> 1.40.41 PERSEDIAAN KAIN DI PEMAKLOON </option><option value = '1.40.51'> 1.40.51 PERSEDIAAN AKSESORIS DI PEMAKLOON </option><option value = '1.40.61'> 1.40.61 PERSEDIAAN BARANG JADI DI PEMAKLOON </option><option value = '1.41.01'> 1.41.01 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - FOB </option><option value = '1.41.02'> 1.41.02 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - FOB </option><option value = '1.41.03'> 1.41.03 PERSEDIAAN BARANG DALAM PROSES - FINISHING - FOB </option><option value = '1.41.11'> 1.41.11 PERSEDIAAN BARANG DALAM PROSES - PERSIAPAN - CMT </option><option value = '1.41.12'> 1.41.12 PERSEDIAAN BARANG DALAM PROSES - PRODUKSI - CMT </option><option value = '1.41.13'> 1.41.13 PERSEDIAAN BARANG DALAM PROSES - FINISHING - CMT </option><option value = '1.41.21'> 1.41.21 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - FOB </option><option value = '1.41.31'> 1.41.31 PERSEDIAAN BARANG DALAM PROSES DI PEMAKLOON - CMT </option><option value = '1.41.41'> 1.41.41 PERSEDIAAN KAIN DI PEMAKLOON </option><option value = '1.41.51'> 1.41.51 PERSEDIAAN AKSESORIS DI PEMAKLOON </option><option value = '1.41.61'> 1.41.61 PERSEDIAAN BARANG JADI DI PEMAKLOON </option><option value = '1.42.01'> 1.42.01 PERSEDIAAN BENANG WARNA </option><option value = '1.42.02'> 1.42.02 PERSEDIAAN BENANG WARNA CMT </option><option value = '1.42.11'> 1.42.11 PERSEDIAAN GREY </option><option value = '1.42.12'> 1.42.12 PERSEDIAAN GREY CMT </option><option value = '1.42.21'> 1.42.21 PERSEDIAAN KAIN </option><option value = '1.42.22'> 1.42.22 PERSEDIAAN KAIN CMT </option><option value = '1.42.31'> 1.42.31 PERSEDIAAN PAKAIAN JADI FOB </option><option value = '1.42.32'> 1.42.32 PERSEDIAAN PAKAIAN JADI CMT </option><option value = '1.43.01'> 1.43.01 PERSEDIAAN BENANG WARNA </option><option value = '1.43.02'> 1.43.02 PERSEDIAAN BENANG WARNA CMT </option><option value = '1.43.11'> 1.43.11 PERSEDIAAN GREY </option><option value = '1.43.12'> 1.43.12 PERSEDIAAN GREY CMT </option><option value = '1.43.21'> 1.43.21 PERSEDIAAN KAIN </option><option value = '1.43.22'> 1.43.22 PERSEDIAAN KAIN CMT </option><option value = '1.43.31'> 1.43.31 PERSEDIAAN PAKAIAN JADI FOB </option><option value = '1.43.32'> 1.43.32 PERSEDIAAN PAKAIAN JADI CMT </option><option value = '1.44.01'> 1.44.01 PERSEDIAAN SPAREPARTS - MECHANICAL </option><option value = '1.44.02'> 1.44.02 PERSEDIAAN SPAREPARTS - ELECTRICAL </option><option value = '1.44.03'> 1.44.03 PERSEDIAAN SPAREPARTS - TOOLS </option><option value = '1.44.04'> 1.44.04 PERSEDIAAN SPAREPARTS - LIQUID </option><option value = '1.44.05'> 1.44.05 PERSEDIAAN SPAREPARTS - FACTORY SUPPLIES </option><option value = '1.45.01'> 1.45.01 PERSEDIAAN SPAREPARTS - MECHANICAL </option><option value = '1.45.02'> 1.45.02 PERSEDIAAN SPAREPARTS - ELECTRICAL </option><option value = '1.45.03'> 1.45.03 PERSEDIAAN SPAREPARTS - TOOLS </option><option value = '1.45.04'> 1.45.04 PERSEDIAAN SPAREPARTS - LIQUID </option><option value = '1.45.05'> 1.45.05 PERSEDIAAN SPAREPARTS - FACTORY SUPPLIES </option><option value = '1.46.01'> 1.46.01 PERSEDIAAN BATUBARA </option><option value = '1.46.02'> 1.46.02 PERSEDIAAN SOLAR PABRIK </option><option value = '1.46.03'> 1.46.03 PERSEDIAAN ELPIJI </option><option value = '1.47.01'> 1.47.01 PERSEDIAAN BATUBARA </option><option value = '1.47.02'> 1.47.02 PERSEDIAAN SOLAR PABRIK </option><option value = '1.47.03'> 1.47.03 PERSEDIAAN ELPIJI </option><option value = '1.48.01'> 1.48.01 PERSEDIAAN ATK </option><option value = '1.48.02'> 1.48.02 PERSEDIAAN UMUM </option><option value = '1.49.01'> 1.49.01 PERSEDIAAN ATK </option><option value = '1.49.02'> 1.49.02 PERSEDIAAN UMUM </option><option value = '1.50.01'> 1.50.01 UANG MUKA PEMBELIAN ASET TETAP </option><option value = '1.50.11'> 1.50.11 UANG MUKA PEMBELIAN BAHAN BAKU / BAHAN PEMBANTU </option><option value = '1.50.21'> 1.50.21 UANG MUKA PEMBELIAN SPAREPARTS </option><option value = '1.50.81'> 1.50.81 UANG MUKA PEMBELIAN JASA </option><option value = '1.50.99'> 1.50.99 UANG MUKA PEMBELIAN LAIN-LAIN </option><option value = '1.51.01'> 1.51.01 BIAYA DIBAYAR DIMUKA - SEWA </option><option value = '1.51.02'> 1.51.02 BIAYA DIBAYAR DIMUKA - ASURANSI </option><option value = '1.51.99'> 1.51.99 BIAYA DIBAYAR DIMUKA - LAIN-LAIN </option><option value = '1.52.01'> 1.52.01 PAJAK DIBAYAR DIMUKA PPH PASAL 22 </option><option value = '1.52.02'> 1.52.02 PAJAK DIBAYAR DIMUKA PPH PASAL 23 </option><option value = '1.52.03'> 1.52.03 PAJAK DIBAYAR DIMUKA PPH PASAL 25 </option><option value = '1.52.04'> 1.52.04 PAJAK DIBAYAR DIMUKA PPN MASUKAN </option><option value = '1.52.05'> 1.52.05 PAJAK DIBAYAR DIMUKA PPH PASAL 4 AYAT 2 </option><option value = '1.52.06'> 1.52.06 PAJAK DIBAYAR DIMUKA PPH PASAL 21 </option><option value = '1.52.07'> 1.52.07 PAJAK DIBAYAR DIMUKA PPN MASUKAN (UNBILLED) </option><option value = '1.53.01'> 1.53.01 PPH BADAN LB PASAL 28A </option><option value = '1.54.01'> 1.54.01 PEMBELIAN DIBAYAR DIMUKA ASET TETAP </option><option value = '1.54.11'> 1.54.11 PEMBELIAN DIBAYAR DIMUKA BAHAN BAKU / BAHAN PEMBANTU </option><option value = '1.54.21'> 1.54.21 PEMBELIAN DIBAYAR DIMUKA SPAREPARTS </option><option value = '1.54.81'> 1.54.81 PEMBELIAN DIBAYAR DIMUKA JASA </option><option value = '1.54.99'> 1.54.99 PEMBELIAN DIBAYAR DIMUKA LAIN-LAIN </option><option value = '1.60.01'> 1.60.01 TANAH </option><option value = '1.61.01'> 1.61.01 BANGUNAN </option><option value = '1.62.01'> 1.62.01 INSTALASI LISTRIK </option><option value = '1.62.02'> 1.62.02 INSTALASI AIR </option><option value = '1.63.01'> 1.63.01 MESIN </option><option value = '1.64.01'> 1.64.01 PERALATAN PABRIK </option><option value = '1.65.01'> 1.65.01 KENDARAAN </option><option value = '1.66.01'> 1.66.01 PERALATAN KANTOR </option><option value = '1.66.02'> 1.66.02 PERALATAN IT </option><option value = '1.69.01'> 1.69.01 PERANGKAT LUNAK </option><option value = '1.71.01'> 1.71.01 AKUMULASI PENYUSUTAN BANGUNAN </option><option value = '1.72.01'> 1.72.01 AKUMULASI PENYUSUTAN INSTALASI LISTRIK </option><option value = '1.72.02'> 1.72.02 AKUMULASI PENYUSUTAN INSTALASI AIR </option><option value = '1.73.01'> 1.73.01 AKUMULASI PENYUSUTAN MESIN </option><option value = '1.74.01'> 1.74.01 AKUMULASI PENYUSUTAN PERALATAN PABRIK </option><option value = '1.75.01'> 1.75.01 AKUMULASI PENYUSUTAN KENDARAAN </option><option value = '1.76.01'> 1.76.01 AKUMULASI PENYUSUTAN PERALATAN KANTOR </option><option value = '1.76.02'> 1.76.02 AKUMULASI PENYUSUTAN PERALATAN IT </option><option value = '1.79.01'> 1.79.01 AKUMULASI AMORTISASI PERANGKAT LUNAK </option><option value = '1.80.01'> 1.80.01 ASET DALAM PENYELESAIAN - BANGUNAN </option><option value = '1.80.11'> 1.80.11 ASET DALAM PENYELESAIAN - INSTALASI LISTRIK </option><option value = '1.80.12'> 1.80.12 ASET DALAM PENYELESAIAN - INSTALASI AIR </option><option value = '1.80.91'> 1.80.91 ASET DALAM PENYELESAIAN - PERANGKAT LUNAK </option><option value = '1.90.01'> 1.90.01 POS SILANG </option><option value = '2.10.01'> 2.10.01 GR/IR - CHEMICAL </option><option value = '2.10.02'> 2.10.02 GR/IR - BENANG </option><option value = '2.10.03'> 2.10.03 GR/IR - KAIN GREY </option><option value = '2.10.04'> 2.10.04 GR/IR - KAIN MATANG </option><option value = '2.10.05'> 2.10.05 GR/IR - PAKAIAN JADI </option><option value = '2.10.06'> 2.10.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.10.07'> 2.10.07 GR/IR - SPAREPARTS </option><option value = '2.10.08'> 2.10.08 GR/IR - BAHAN BAKAR </option><option value = '2.10.09'> 2.10.09 GR/IR - ATK </option><option value = '2.10.10'> 2.10.10 GR/IR - MESIN </option><option value = '2.10.11'> 2.10.11 GR/IR - MAKLOON </option><option value = '2.10.49'> 2.10.49 GR/IR - LAIN-LAIN </option><option value = '2.10.51'> 2.10.51 UTANG USAHA - CHEMICAL </option><option value = '2.10.52'> 2.10.52 UTANG USAHA - BENANG </option><option value = '2.10.53'> 2.10.53 UTANG USAHA - KAIN GREY </option><option value = '2.10.54'> 2.10.54 UTANG USAHA - KAIN MATANG </option><option value = '2.10.55'> 2.10.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.10.56'> 2.10.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.10.57'> 2.10.57 UTANG USAHA - SPAREPARTS </option><option value = '2.10.58'> 2.10.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.10.59'> 2.10.59 UTANG USAHA - ATK </option><option value = '2.10.60'> 2.10.60 UTANG USAHA - MESIN </option><option value = '2.10.61'> 2.10.61 UTANG USAHA - MAKLOON </option><option value = '2.10.99'> 2.10.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.11.01'> 2.11.01 GR/IR - CHEMICAL </option><option value = '2.11.02'> 2.11.02 GR/IR - BENANG </option><option value = '2.11.03'> 2.11.03 GR/IR - KAIN GREY </option><option value = '2.11.04'> 2.11.04 GR/IR - KAIN MATANG </option><option value = '2.11.05'> 2.11.05 GR/IR - PAKAIAN JADI </option><option value = '2.11.06'> 2.11.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.11.07'> 2.11.07 GR/IR - SPAREPARTS </option><option value = '2.11.08'> 2.11.08 GR/IR - BAHAN BAKAR </option><option value = '2.11.09'> 2.11.09 GR/IR - ATK </option><option value = '2.11.10'> 2.11.10 GR/IR - MESIN </option><option value = '2.11.11'> 2.11.11 GR/IR - MAKLOON </option><option value = '2.11.49'> 2.11.49 GR/IR - LAIN-LAIN </option><option value = '2.11.51'> 2.11.51 UTANG USAHA - CHEMICAL </option><option value = '2.11.52'> 2.11.52 UTANG USAHA - BENANG </option><option value = '2.11.53'> 2.11.53 UTANG USAHA - KAIN GREY </option><option value = '2.11.54'> 2.11.54 UTANG USAHA - KAIN MATANG </option><option value = '2.11.55'> 2.11.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.11.56'> 2.11.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.11.57'> 2.11.57 UTANG USAHA - SPAREPARTS </option><option value = '2.11.58'> 2.11.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.11.59'> 2.11.59 UTANG USAHA - ATK </option><option value = '2.11.60'> 2.11.60 UTANG USAHA - MESIN </option><option value = '2.11.61'> 2.11.61 UTANG USAHA - MAKLOON </option><option value = '2.11.99'> 2.11.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.12.01'> 2.12.01 GR/IR - CHEMICAL </option><option value = '2.12.02'> 2.12.02 GR/IR - BENANG </option><option value = '2.12.03'> 2.12.03 GR/IR - KAIN GREY </option><option value = '2.12.04'> 2.12.04 GR/IR - KAIN MATANG </option><option value = '2.12.05'> 2.12.05 GR/IR - PAKAIAN JADI </option><option value = '2.12.06'> 2.12.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.12.07'> 2.12.07 GR/IR - SPAREPARTS </option><option value = '2.12.08'> 2.12.08 GR/IR - BAHAN BAKAR </option><option value = '2.12.09'> 2.12.09 GR/IR - ATK </option><option value = '2.12.10'> 2.12.10 GR/IR - MESIN </option><option value = '2.12.11'> 2.12.11 GR/IR - MAKLOON </option><option value = '2.12.49'> 2.12.49 GR/IR - LAIN-LAIN </option><option value = '2.12.51'> 2.12.51 UTANG USAHA - CHEMICAL </option><option value = '2.12.52'> 2.12.52 UTANG USAHA - BENANG </option><option value = '2.12.53'> 2.12.53 UTANG USAHA - KAIN GREY </option><option value = '2.12.54'> 2.12.54 UTANG USAHA - KAIN MATANG </option><option value = '2.12.55'> 2.12.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.12.56'> 2.12.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.12.57'> 2.12.57 UTANG USAHA - SPAREPARTS </option><option value = '2.12.58'> 2.12.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.12.59'> 2.12.59 UTANG USAHA - ATK </option><option value = '2.12.60'> 2.12.60 UTANG USAHA - MESIN </option><option value = '2.12.61'> 2.12.61 UTANG USAHA - MAKLOON </option><option value = '2.12.99'> 2.12.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.13.01'> 2.13.01 GR/IR - CHEMICAL </option><option value = '2.13.02'> 2.13.02 GR/IR - BENANG </option><option value = '2.13.03'> 2.13.03 GR/IR - KAIN GREY </option><option value = '2.13.04'> 2.13.04 GR/IR - KAIN MATANG </option><option value = '2.13.05'> 2.13.05 GR/IR - PAKAIAN JADI </option><option value = '2.13.06'> 2.13.06 GR/IR - BAHAN PEMBANTU </option><option value = '2.13.07'> 2.13.07 GR/IR - SPAREPARTS </option><option value = '2.13.08'> 2.13.08 GR/IR - BAHAN BAKAR </option><option value = '2.13.09'> 2.13.09 GR/IR - ATK </option><option value = '2.13.10'> 2.13.10 GR/IR - MESIN </option><option value = '2.13.11'> 2.13.11 GR/IR - MAKLOON </option><option value = '2.13.49'> 2.13.49 GR/IR - LAIN-LAIN </option><option value = '2.13.51'> 2.13.51 UTANG USAHA - CHEMICAL </option><option value = '2.13.52'> 2.13.52 UTANG USAHA - BENANG </option><option value = '2.13.53'> 2.13.53 UTANG USAHA - KAIN GREY </option><option value = '2.13.54'> 2.13.54 UTANG USAHA - KAIN MATANG </option><option value = '2.13.55'> 2.13.55 UTANG USAHA - PAKAIAN JADI </option><option value = '2.13.56'> 2.13.56 UTANG USAHA - BAHAN PEMBANTU </option><option value = '2.13.57'> 2.13.57 UTANG USAHA - SPAREPARTS </option><option value = '2.13.58'> 2.13.58 UTANG USAHA - BAHAN BAKAR </option><option value = '2.13.59'> 2.13.59 UTANG USAHA - ATK </option><option value = '2.13.60'> 2.13.60 UTANG USAHA - MESIN </option><option value = '2.13.61'> 2.13.61 UTANG USAHA - MAKLOON </option><option value = '2.13.99'> 2.13.99 UTANG USAHA - LAIN-LAIN </option><option value = '2.14.99'> 2.14.99 UTANG LAIN-LAIN </option><option value = '2.15.01'> 2.15.01 UTANG LAIN-LAIN - DIREKSI </option><option value = '2.15.99'> 2.15.99 UTANG LAIN-LAIN </option><option value = '2.20.01'> 2.20.01 OVERDRAFT BCA 008-997-1979 </option><option value = '2.20.02'> 2.20.02 OVERDRAFT BCA 008-998-1982 </option><option value = '2.50.01'> 2.50.01 UANG MUKA PENJUALAN EKSPOR </option><option value = '2.50.02'> 2.50.02 UANG MUKA PENJUALAN LOKAL </option><option value = '2.51.01'> 2.51.01 BIAYA YANG MASIH HARUS DIBAYAR - LISTRIK </option><option value = '2.51.02'> 2.51.02 BIAYA YANG MASIH HARUS DIBAYAR - AIR </option><option value = '2.51.11'> 2.51.11 BIAYA YANG MASIH HARUS DIBAYAR - TELP </option><option value = '2.51.12'> 2.51.12 BIAYA YANG MASIH HARUS DIBAYAR - INTERNET </option><option value = '2.51.21'> 2.51.21 BIAYA YANG MASIH HARUS DIBAYAR - GAJI </option><option value = '2.51.22'> 2.51.22 BIAYA YANG MASIH HARUS DIBAYAR - THR </option><option value = '2.51.31'> 2.51.31 BIAYA YANG MASIH HARUS DIBAYAR - BPJS </option><option value = '2.51.41'> 2.51.41 BIAYA YANG MASIH HARUS DIBAYAR - SEWA </option><option value = '2.51.51'> 2.51.51 BIAYA YANG MASIH HARUS DIBAYAR - EMKL </option><option value = '2.51.61'> 2.51.61 BIAYA YANG MASIH HARUS DIBAYAR - FOTOKOPI </option><option value = '2.52.01'> 2.52.01 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 21 </option><option value = '2.52.02'> 2.52.02 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 4 (2) </option><option value = '2.52.03'> 2.52.03 PAJAK YANG MASIH HARUS DIBAYAR - PPN </option><option value = '2.52.04'> 2.52.04 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 25/29 </option><option value = '2.52.05'> 2.52.05 PAJAK YANG MASIH HARUS DIBAYAR - PPH PASAL 23 </option><option value = '2.52.06'> 2.52.06 PAJAK YANG MASIH HARUS DIBAYAR - PBB </option><option value = '2.53.01'> 2.53.01 PPN KELUARAN </option><option value = '2.60.01'> 2.60.01 UTANG BANK JANGKA PANJANG </option><option value = '3.10.01'> 3.10.01 MODAL SAHAM </option><option value = '3.20.01'> 3.20.01 TAMBAHAN MODAL DISETOR (AMNESTI PAJAK) </option><option value = '3.30.01'> 3.30.01 LABA DITAHAN </option><option value = '3.40.01'> 3.40.01 LABA TAHUN BERJALAN </option><option value = '4.01.01'> 4.01.01 PENJUALAN BENANG GREY </option><option value = '4.01.02'> 4.01.02 PENJUALAN BENANG WARNA </option><option value = '4.01.51'> 4.01.51 PENJUALAN BENANG GREY - B GRADE </option><option value = '4.01.52'> 4.01.52 PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.02.01'> 4.02.01 PENJUALAN KAIN GREY </option><option value = '4.02.51'> 4.02.51 PENJUALAN KAIN GREY - B GRADE </option><option value = '4.03.01'> 4.03.01 PENJUALAN KAIN STRIPPER </option><option value = '4.03.51'> 4.03.51 PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.04.01'> 4.04.01 PENJUALAN KAIN MATANG </option><option value = '4.04.51'> 4.04.51 PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.05.01'> 4.05.01 PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '4.05.02'> 4.05.02 PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '4.05.51'> 4.05.51 PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '4.05.52'> 4.05.52 PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '4.06.01'> 4.06.01 PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '4.06.02'> 4.06.02 PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '4.06.51'> 4.06.51 PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '4.06.52'> 4.06.52 PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '4.07.01'> 4.07.01 PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.07.02'> 4.07.02 PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.07.03'> 4.07.03 PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.07.04'> 4.07.04 PENJUALAN LAINNYA - SAMPAH </option><option value = '4.10.01'> 4.10.01 PENJUALAN BENANG GREY </option><option value = '4.10.02'> 4.10.02 PENJUALAN BENANG WARNA </option><option value = '4.10.51'> 4.10.51 PENJUALAN BENANG GREY - B GRADE </option><option value = '4.10.52'> 4.10.52 PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.11.01'> 4.11.01 PENJUALAN KAIN GREY </option><option value = '4.11.51'> 4.11.51 PENJUALAN KAIN GREY - B GRADE </option><option value = '4.12.01'> 4.12.01 PENJUALAN KAIN STRIPPER </option><option value = '4.12.51'> 4.12.51 PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.13.01'> 4.13.01 PENJUALAN KAIN MATANG </option><option value = '4.13.51'> 4.13.51 PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.14.01'> 4.14.01 PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '4.14.02'> 4.14.02 PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '4.14.51'> 4.14.51 PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '4.14.52'> 4.14.52 PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '4.15.01'> 4.15.01 PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '4.15.02'> 4.15.02 PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '4.15.51'> 4.15.51 PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '4.15.52'> 4.15.52 PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '4.16.01'> 4.16.01 PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.16.02'> 4.16.02 PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.16.03'> 4.16.03 PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.16.04'> 4.16.04 PENJUALAN LAINNYA - SAMPAH </option><option value = '4.20.01'> 4.20.01 JASA DYEING BENANG </option><option value = '4.21.01'> 4.21.01 JASA DYEING KAIN </option><option value = '4.22.01'> 4.22.01 JASA KNITTING </option><option value = '4.23.01'> 4.23.01 JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.24.01'> 4.24.01 JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.25.01'> 4.25.01 JASA LAINNYA </option><option value = '4.30.01'> 4.30.01 JASA DYEING BENANG </option><option value = '4.31.01'> 4.31.01 JASA DYEING KAIN </option><option value = '4.32.01'> 4.32.01 JASA KNITTING </option><option value = '4.33.01'> 4.33.01 JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.34.01'> 4.34.01 JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.35.01'> 4.35.01 JASA LAINNYA </option><option value = '4.40.01'> 4.40.01 RETUR PENJUALAN BENANG GREY </option><option value = '4.40.02'> 4.40.02 RETUR PENJUALAN BENANG WARNA </option><option value = '4.40.51'> 4.40.51 RETUR PENJUALAN BENANG GREY - B GRADE </option><option value = '4.40.52'> 4.40.52 RETUR PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.41.01'> 4.41.01 RETUR PENJUALAN KAIN GREY </option><option value = '4.41.51'> 4.41.51 RETUR PENJUALAN KAIN GREY - B GRADE </option><option value = '4.42.01'> 4.42.01 RETUR PENJUALAN KAIN STRIPPER </option><option value = '4.42.51'> 4.42.51 RETUR PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.43.01'> 4.43.01 RETUR PENJUALAN KAIN MATANG </option><option value = '4.43.51'> 4.43.51 RETUR PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.44.01'> 4.44.01 RETUR PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.44.51'> 4.44.51 RETUR PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.45.01'> 4.45.01 RETUR PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.45.51'> 4.45.51 RETUR PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.46.01'> 4.46.01 RETUR PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.46.02'> 4.46.02 RETUR PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.46.03'> 4.46.03 RETUR PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.46.04'> 4.46.04 RETUR PENJUALAN LAINNYA - SAMPAH </option><option value = '4.47.01'> 4.47.01 JASA DYEING BENANG </option><option value = '4.48.01'> 4.48.01 JASA DYEING KAIN </option><option value = '4.49.01'> 4.49.01 JASA KNITTING </option><option value = '4.50.01'> 4.50.01 JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.51.01'> 4.51.01 JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.52.01'> 4.52.01 JASA LAINNYA </option><option value = '4.55.01'> 4.55.01 RETUR PENJUALAN BENANG </option><option value = '4.55.02'> 4.55.02 RETUR PENJUALAN BENANG WARNA </option><option value = '4.55.51'> 4.55.51 RETUR PENJUALAN BENANG - B GRADE </option><option value = '4.55.52'> 4.55.52 RETUR PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.56.01'> 4.56.01 RETUR PENJUALAN KAIN GREY </option><option value = '4.56.51'> 4.56.51 RETUR PENJUALAN KAIN GREY - B GRADE </option><option value = '4.57.01'> 4.57.01 RETUR PENJUALAN KAIN STRIPPER </option><option value = '4.57.51'> 4.57.51 RETUR PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.58.01'> 4.58.01 RETUR PENJUALAN KAIN MATANG </option><option value = '4.58.51'> 4.58.51 RETUR PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.59.01'> 4.59.01 RETUR PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.59.51'> 4.59.51 RETUR PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.60.01'> 4.60.01 RETUR PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.60.51'> 4.60.51 RETUR PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.61.01'> 4.61.01 RETUR PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.61.02'> 4.61.02 RETUR PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.61.03'> 4.61.03 RETUR PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.61.04'> 4.61.04 RETUR PENJUALAN LAINNYA - SAMPAH </option><option value = '4.62.01'> 4.62.01 RETUR PENDAPATAN JASA DYEING BENANG </option><option value = '4.63.01'> 4.63.01 RETUR PENDAPATAN JASA DYEING KAIN </option><option value = '4.64.01'> 4.64.01 RETUR PENDAPATAN JASA KNITTING </option><option value = '4.65.01'> 4.65.01 RETUR PENDAPATAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.66.01'> 4.66.01 RETUR PENDAPATAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.67.01'> 4.67.01 RETUR PENDAPATAN JASA LAINNYA </option><option value = '4.70.01'> 4.70.01 POTONGAN PENJUALAN BENANG </option><option value = '4.70.11'> 4.70.11 POTONGAN PENJUALAN BENANG WARNA </option><option value = '4.70.21'> 4.70.21 POTONGAN PENJUALAN BENANG - B GRADE </option><option value = '4.70.31'> 4.70.31 POTONGAN PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.71.01'> 4.71.01 POTONGAN PENJUALAN KAIN GREY </option><option value = '4.71.11'> 4.71.11 POTONGAN PENJUALAN KAIN GREY - B GRADE </option><option value = '4.72.01'> 4.72.01 POTONGAN PENJUALAN KAIN STRIPPER </option><option value = '4.72.51'> 4.72.51 POTONGAN PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.73.01'> 4.73.01 POTONGAN PENJUALAN KAIN MATANG </option><option value = '4.73.51'> 4.73.51 POTONGAN PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.74.01'> 4.74.01 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.74.51'> 4.74.51 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.75.01'> 4.75.01 POTONGAN PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.75.51'> 4.75.51 POTONGAN PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.76.01'> 4.76.01 POTONGAN PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.76.02'> 4.76.02 POTONGAN PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.76.03'> 4.76.03 POTONGAN PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.76.04'> 4.76.04 POTONGAN PENJUALAN LAINNYA - SAMPAH </option><option value = '4.77.01'> 4.77.01 POTONGAN JASA DYEING BENANG </option><option value = '4.78.01'> 4.78.01 POTONGAN JASA DYEING KAIN </option><option value = '4.79.01'> 4.79.01 POTONGAN JASA KNITTING </option><option value = '4.80.01'> 4.80.01 POTONGAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.81.01'> 4.81.01 POTONGAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.82.01'> 4.82.01 POTONGAN JASA LAINNYA </option><option value = '4.85.01'> 4.85.01 POTONGAN PENJUALAN BENANG </option><option value = '4.85.02'> 4.85.02 POTONGAN PENJUALAN BENANG WARNA </option><option value = '4.85.51'> 4.85.51 POTONGAN PENJUALAN BENANG - B GRADE </option><option value = '4.85.52'> 4.85.52 POTONGAN PENJUALAN BENANG WARNA - B GRADE </option><option value = '4.86.01'> 4.86.01 POTONGAN PENJUALAN KAIN GREY </option><option value = '4.86.51'> 4.86.51 POTONGAN PENJUALAN KAIN GREY - B GRADE </option><option value = '4.87.01'> 4.87.01 POTONGAN PENJUALAN KAIN STRIPPER </option><option value = '4.87.51'> 4.87.51 POTONGAN PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '4.88.01'> 4.88.01 POTONGAN PENJUALAN KAIN MATANG </option><option value = '4.88.51'> 4.88.51 POTONGAN PENJUALAN KAIN MATANG - B GRADE </option><option value = '4.89.01'> 4.89.01 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR </option><option value = '4.89.51'> 4.89.51 POTONGAN PENJUALAN PAKAIAN JADI EKSPOR - B GRADE </option><option value = '4.90.01'> 4.90.01 POTONGAN PENJUALAN PAKAIAN JADI LOKAL </option><option value = '4.90.51'> 4.90.51 POTONGAN PENJUALAN PAKAIAN JADI LOKAL - B GRADE </option><option value = '4.91.01'> 4.91.01 POTONGAN PENJUALAN LAINNYA - DYESTUFF </option><option value = '4.91.02'> 4.91.02 POTONGAN PENJUALAN LAINNYA - CHEMICAL </option><option value = '4.91.03'> 4.91.03 POTONGAN PENJUALAN LAINNYA - ACCESSORIES </option><option value = '4.91.04'> 4.91.04 POTONGAN PENJUALAN LAINNYA - SAMPAH </option><option value = '4.92.01'> 4.92.01 POTONGAN JASA DYEING BENANG </option><option value = '4.93.01'> 4.93.01 POTONGAN JASA DYEING KAIN </option><option value = '4.94.01'> 4.94.01 POTONGAN JASA KNITTING </option><option value = '4.95.01'> 4.95.01 POTONGAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '4.96.01'> 4.96.01 POTONGAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '4.97.01'> 4.97.01 POTONGAN JASA LAINNYA </option><option value = '5.01.01'> 5.01.01 HARGA POKOK PENJUALAN BENANG GREY </option><option value = '5.01.02'> 5.01.02 HARGA POKOK PENJUALAN BENANG WARNA </option><option value = '5.01.51'> 5.01.51 HARGA POKOK PENJUALAN BENANG GREY - B GRADE </option><option value = '5.01.52'> 5.01.52 HARGA POKOK PENJUALAN BENANG WARNA - B GRADE </option><option value = '5.02.01'> 5.02.01 HARGA POKOK PENJUALAN KAIN GREY </option><option value = '5.02.51'> 5.02.51 HARGA POKOK PENJUALAN KAIN GREY - B GRADE </option><option value = '5.03.01'> 5.03.01 HARGA POKOK PENJUALAN KAIN STRIPPER </option><option value = '5.03.51'> 5.03.51 HARGA POKOK PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '5.04.01'> 5.04.01 HARGA POKOK PENJUALAN KAIN MATANG </option><option value = '5.04.51'> 5.04.51 HARGA POKOK PENJUALAN KAIN MATANG - B GRADE </option><option value = '5.05.01'> 5.05.01 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '5.05.02'> 5.05.02 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '5.05.51'> 5.05.51 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '5.05.52'> 5.05.52 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '5.06.01'> 5.06.01 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '5.06.02'> 5.06.02 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '5.06.51'> 5.06.51 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '5.06.52'> 5.06.52 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '5.07.01'> 5.07.01 HARGA POKOK PENJUALAN LAINNYA - DYESTUFF </option><option value = '5.07.02'> 5.07.02 HARGA POKOK PENJUALAN LAINNYA - CHEMICAL </option><option value = '5.07.03'> 5.07.03 HARGA POKOK PENJUALAN LAINNYA - ACCESSORIES </option><option value = '5.07.04'> 5.07.04 HARGA POKOK PENJUALAN LAINNYA - SAMPAH </option><option value = '5.08.01'> 5.08.01 HARGA POKOK PENDAPATAN JASA DYEING BENANG </option><option value = '5.09.01'> 5.09.01 HARGA POKOK PENDAPATAN JASA DYEING KAIN </option><option value = '5.10.01'> 5.10.01 HARGA POKOK PENDAPATAN JASA KNITTING </option><option value = '5.11.01'> 5.11.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '5.12.01'> 5.12.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '5.13.01'> 5.13.01 HARGA POKOK PENDAPATAN JASA LAINNYA </option><option value = '5.14.01'> 5.14.01 HARGA POKOK PENJUALAN BENANG GREY </option><option value = '5.14.02'> 5.14.02 HARGA POKOK PENJUALAN BENANG WARNA </option><option value = '5.14.51'> 5.14.51 HARGA POKOK PENJUALAN BENANG GREY - B GRADE </option><option value = '5.14.52'> 5.14.52 HARGA POKOK PENJUALAN BENANG WARNA - B GRADE </option><option value = '5.15.01'> 5.15.01 HARGA POKOK PENJUALAN KAIN GREY </option><option value = '5.15.51'> 5.15.51 HARGA POKOK PENJUALAN KAIN GREY - B GRADE </option><option value = '5.16.01'> 5.16.01 HARGA POKOK PENJUALAN KAIN STRIPPER </option><option value = '5.16.51'> 5.16.51 HARGA POKOK PENJUALAN KAIN STRIPPER - B GRADE </option><option value = '5.17.01'> 5.17.01 HARGA POKOK PENJUALAN KAIN MATANG </option><option value = '5.17.51'> 5.17.51 HARGA POKOK PENJUALAN KAIN MATANG - B GRADE </option><option value = '5.18.01'> 5.18.01 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - FOB </option><option value = '5.18.02'> 5.18.02 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR - CMT </option><option value = '5.18.51'> 5.18.51 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR FOB - B GRADE </option><option value = '5.18.52'> 5.18.52 HARGA POKOK PENJUALAN PAKAIAN JADI EKSPOR CMT - B GRADE </option><option value = '5.19.01'> 5.19.01 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB </option><option value = '5.19.02'> 5.19.02 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT </option><option value = '5.19.51'> 5.19.51 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL FOB - B GRADE </option><option value = '5.19.52'> 5.19.52 HARGA POKOK PENJUALAN PAKAIAN JADI LOKAL CMT - B GRADE </option><option value = '5.20.01'> 5.20.01 HARGA POKOK PENJUALAN LAINNYA - DYESTUFF </option><option value = '5.20.02'> 5.20.02 HARGA POKOK PENJUALAN LAINNYA - CHEMICAL </option><option value = '5.20.03'> 5.20.03 HARGA POKOK PENJUALAN LAINNYA - ACCESSORIES </option><option value = '5.20.04'> 5.20.04 HARGA POKOK PENJUALAN LAINNYA - SAMPAH </option><option value = '5.21.01'> 5.21.01 HARGA POKOK PENDAPATAN JASA DYEING BENANG </option><option value = '5.22.01'> 5.22.01 HARGA POKOK PENDAPATAN JASA DYEING KAIN </option><option value = '5.23.01'> 5.23.01 HARGA POKOK PENDAPATAN JASA KNITTING </option><option value = '5.24.01'> 5.24.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI EKSPOR CMT </option><option value = '5.25.01'> 5.25.01 HARGA POKOK PENDAPATAN JASA JAHIT PAKAIAN JADI LOKAL CMT </option><option value = '5.26.01'> 5.26.01 HARGA POKOK PENDAPATAN JASA LAINNYA </option><option value = '5.27.01'> 5.27.01 BB - CHEMICAL </option><option value = '5.27.02'> 5.27.02 BB - CHEMICAL DYESTUFF </option><option value = '5.27.03'> 5.27.03 BB - CHEMICAL CALLATOR </option><option value = '5.27.04'> 5.27.04 BB - CHEMICAL DYEING </option><option value = '5.27.05'> 5.27.05 BB - CHEMICAL FINISHING </option><option value = '5.28.01'> 5.28.01 BB - BENANG </option><option value = '5.28.02'> 5.28.02 BB - BENANG GREY </option><option value = '5.28.03'> 5.28.03 BB - BENANG WARNA </option><option value = '5.29.01'> 5.29.01 BB - GREY </option><option value = '5.30.01'> 5.30.01 BB - KAIN MATANG </option><option value = '5.31.01'> 5.31.01 BB - CHEMICAL </option><option value = '5.31.02'> 5.31.02 BB - CHEMICAL DYESTUFF </option><option value = '5.31.03'> 5.31.03 BB - CHEMICAL CALLATOR </option><option value = '5.31.04'> 5.31.04 BB - CHEMICAL DYEING </option><option value = '5.31.05'> 5.31.05 BB - CHEMICAL FINISHING </option><option value = '5.32.01'> 5.32.01 BB - BENANG </option><option value = '5.32.02'> 5.32.02 BB - BENANG GREY </option><option value = '5.32.03'> 5.32.03 BB - BENANG WARNA </option><option value = '5.33.01'> 5.33.01 BB - GREY </option><option value = '5.34.01'> 5.34.01 BB - KAIN MATANG </option><option value = '5.35.01'> 5.35.01 BP - DUS </option><option value = '5.35.02'> 5.35.02 BP - PLASTIK </option><option value = '5.35.03'> 5.35.03 BP - CONES </option><option value = '5.35.04'> 5.35.04 BP - AKSESORIS - SEWING </option><option value = '5.35.05'> 5.35.05 BP - AKSESORIS - PACKING </option><option value = '5.36.01'> 5.36.01 BP - DUS </option><option value = '5.36.02'> 5.36.02 BP - PLASTIK </option><option value = '5.36.03'> 5.36.03 BP - CONES </option><option value = '5.36.04'> 5.36.04 BP - AKSESORIS - SEWING </option><option value = '5.36.05'> 5.36.05 BP - AKSESORIS - PACKING </option><option value = '5.40.01'> 5.40.01 BEBAN GAJI & UPAH TENAGA KERJA LANGSUNG </option><option value = '5.41.01'> 5.41.01 BEBAN TUNJANGAN TENAGA KERJA LANGSUNG </option><option value = '5.42.01'> 5.42.01 BEBAN LEMBUR TENAGA KERJA LANGSUNG </option><option value = '5.43.01'> 5.43.01 BPJS KETENAGAKERJAAN TENAGA KERJA LANGSUNG </option><option value = '5.43.02'> 5.43.02 BPJS KESEHATAN TENAGA KERJA LANGSUNG </option><option value = '5.44.01'> 5.44.01 THR TENAGA KERJA LANGSUNG </option><option value = '5.44.02'> 5.44.02 BONUS TENAGA KERJA LANGSUNG </option><option value = '5.45.01'> 5.45.01 BEBAN MANFAAT KARYAWAN TENAGA KERJA LANGSUNG </option><option value = '5.50.01'> 5.50.01 BEBAN GAJI & UPAH TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.51.01'> 5.51.01 BEBAN TUNJANGAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.52.01'> 5.52.01 BEBAN LEMBUR TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.53.01'> 5.53.01 BPJS KETENAGAKERJAAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.53.02'> 5.53.02 BPJS KESEHATAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.54.01'> 5.54.01 THR TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.54.02'> 5.54.02 BONUS TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.55.01'> 5.55.01 BEBAN MANFAAT KARYAWAN TENAGA KERJA TIDAK LANGSUNG </option><option value = '5.69.01'> 5.69.01 BEBAN MAKLOON DYEING BENANG </option><option value = '5.69.02'> 5.69.02 BEBAN MAKLOON DYEING KAIN </option><option value = '5.69.03'> 5.69.03 BEBAN MAKLOON KNITTING </option><option value = '5.69.04'> 5.69.04 BEBAN MAKLOON PAKAIAN JADI </option><option value = '5.69.05'> 5.69.05 BEBAN MAKLOON PRINTING </option><option value = '5.69.06'> 5.69.06 BEBAN MAKLOON EMBRODEIRY </option><option value = '5.69.07'> 5.69.07 BEBAN MAKLOON WASHING </option><option value = '5.69.08'> 5.69.08 BEBAN MAKLOON KNITTING VIETER BAND </option><option value = '5.69.09'> 5.69.09 BEBAN MAKLOON BUBUT </option><option value = '5.69.10'> 5.69.10 BEBAN MAKLOON PAINTING </option><option value = '5.69.11'> 5.69.11 BEBAN MAKLOON LASER CUTTING </option><option value = '5.69.12'> 5.69.12 BEBAN MAKLOON BONDING </option><option value = '5.69.13'> 5.69.13 BEBAN MAKLOON HEATSEAL </option><option value = '5.69.14'> 5.69.14 BEBAN MAKLOON QUILTING </option><option value = '5.69.97'> 5.69.97 BEBAN MAKLOON KAIN </option><option value = '5.69.98'> 5.69.98 BEBAN MAKLOON AKSESORIS </option><option value = '5.69.99'> 5.69.99 BEBAN MAKLOON LAINNYA </option><option value = '5.70.01'> 5.70.01 BEBAN ENERGI - BATUBARA </option><option value = '5.70.02'> 5.70.02 BEBAN ENERGI - SOLAR </option><option value = '5.70.03'> 5.70.03 BEBAN ENERGI - ELPIJI </option><option value = '5.71.01'> 5.71.01 CHEMICAL IPAL </option><option value = '5.71.02'> 5.71.02 BEBAN BUANG LUMPUR </option><option value = '5.71.03'> 5.71.03 BEBAN BUANG ABU - LUMPUR </option><option value = '5.71.04'> 5.71.04 BEBAN BUANG ABU - BATU BARA </option><option value = '5.71.05'> 5.71.05 BEBAN UJI LAB LIMBAH AIR </option><option value = '5.71.99'> 5.71.99 BEBAN PENGOLAHAN LIMBAH LAINNYA </option><option value = '5.72.01'> 5.72.01 BEBAN SPAREPARTS </option><option value = '5.73.01'> 5.73.01 BEBAN IMPOR MESIN </option><option value = '5.73.02'> 5.73.02 BEBAN IMPOR SPAREPARTS </option><option value = '5.73.03'> 5.73.03 BEBAN IMPOR BAHAN BAKU </option><option value = '5.73.04'> 5.73.04 BEBAN IMPOR BAHAN PEMBANTU </option><option value = '5.74.01'> 5.74.01 BEBAN PENGUJIAN KAIN </option><option value = '5.74.99'> 5.74.99 BEBAN PENGUJIAN DAN PENELITIAN LAINNYA </option><option value = '5.75.01'> 5.75.01 BEBAN SEWA TANAH & BANGUNAN </option><option value = '5.75.02'> 5.75.02 BEBAN SEWA MESIN </option><option value = '5.76.01'> 5.76.01 BEBAN LISTRIK PABRIK </option><option value = '5.77.01'> 5.77.01 BEBAN TELEPON PABRIK </option><option value = '5.77.02'> 5.77.02 BEBAN INTERNET PABRIK </option><option value = '5.78.01'> 5.78.01 BEBAN IURAN AIR PJT </option><option value = '5.78.02'> 5.78.02 BEBAN PAJAK AIR PERMUKAAN </option><option value = '5.78.99'> 5.78.99 BEBAN AIR PABRIK LAINNYA </option><option value = '5.80.01'> 5.80.01 BEBAN PEMELIHARAAN BANGUNAN </option><option value = '5.80.11'> 5.80.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK </option><option value = '5.80.12'> 5.80.12 BEBAN PEMELIHARAAN INSTALASI AIR </option><option value = '5.80.21'> 5.80.21 BEBAN PEMELIHARAAN MESIN </option><option value = '5.80.31'> 5.80.31 BEBAN PEMELIHARAAN PERALATAN PABRIK </option><option value = '5.80.41'> 5.80.41 BEBAN PEMELIHARAAN KENDARAAN </option><option value = '5.81.01'> 5.81.01 BEBAN ASURANSI BANGUNAN </option><option value = '5.81.11'> 5.81.11 BEBAN ASURANSI INSTALASI LISTRIK </option><option value = '5.81.12'> 5.81.12 BEBAN ASURANSI INSTALASI AIR </option><option value = '5.81.21'> 5.81.21 BEBAN ASURANSI MESIN </option><option value = '5.81.31'> 5.81.31 BEBAN ASURANSI PERALATAN PABRIK </option><option value = '5.81.41'> 5.81.41 BEBAN ASURANSI KENDARAAN </option><option value = '5.82.01'> 5.82.01 BEBAN KEPERLUAN KANTOR </option><option value = '5.82.02'> 5.82.02 BEBAN PEMAKAIAN ATK </option><option value = '5.82.03'> 5.82.03 BEBAN FOTOKOPI </option><option value = '5.83.01'> 5.83.01 TRAINING KARYAWAN PABRIK </option><option value = '5.83.02'> 5.83.02 SERAGAM DAN PERLENGKAPAN KERJA KARYAWAN </option><option value = '5.83.03'> 5.83.03 BEBAN KESEHATAN KARYAWAN </option><option value = '5.83.04'> 5.83.04 BEBAN KECELAKAAN KERJA </option><option value = '5.84.01'> 5.84.01 BEBAN TRANSPORTASI </option><option value = '5.84.02'> 5.84.02 BEBAN PERJALANAN DINAS </option><option value = '5.84.03'> 5.84.03 BEBAN EKSPEDISI ANGKUTAN </option><option value = '5.85.01'> 5.85.01 BEBAN KEPERLUAN PABRIK </option><option value = '5.86.01'> 5.86.01 BEBAN PERIZINAN </option><option value = '5.86.02'> 5.86.02 BEBAN RETRIBUSI </option><option value = '5.86.03'> 5.86.03 BEBAN IURAN </option><option value = '5.86.04'> 5.86.04 BEBAN SUMBANGAN </option><option value = '5.87.01'> 5.87.01 BEBAN PENYUSUTAN BANGUNAN </option><option value = '5.87.11'> 5.87.11 BEBAN PENYUSUTAN INSTALASI LISTRIK </option><option value = '5.87.12'> 5.87.12 BEBAN PENYUSUTAN INSTALASI AIR </option><option value = '5.87.21'> 5.87.21 BEBAN PENYUSUTAN MESIN </option><option value = '5.87.31'> 5.87.31 BEBAN PENYUSUTAN PERALATAN PABRIK </option><option value = '5.87.41'> 5.87.41 BEBAN PENYUSUTAN KENDARAAN </option><option value = '5.87.51'> 5.87.51 BEBAN PENYUSUTAN PERALATAN KANTOR </option><option value = '5.87.52'> 5.87.52 BEBAN PENYUSUTAN PERALATAN IT </option><option value = '5.87.91'> 5.87.91 BEBAN AMORTISASI PERANGKAT LUNAK </option><option value = '5.99.01'> 5.99.01 BEBAN PABRIK LAINNYA </option><option value = '5.99.10'> 5.99.10 BEBAN PENYESUAIAN PERSEDIAAN KAIN </option><option value = '5.99.11'> 5.99.11 BEBAN PENYESUAIAN PERSEDIAAN AKSESORIS </option><option value = '5.99.12'> 5.99.12 BEBAN PENYESUAIAN PERSEDIAAN DALAM PROSES </option><option value = '5.99.13'> 5.99.13 BEBAN PENYESUAIAN PERSEDIAAN BARANG JADI </option><option value = '5.99.99'> 5.99.99 BIAYA PRODUKSI BULAN BERJALAN </option><option value = '6.01.01'> 6.01.01 BEBAN GAJI & UPAH </option><option value = '6.02.02'> 6.02.02 BEBAN TUNJANGAN </option><option value = '6.03.03'> 6.03.03 BEBAN LEMBUR </option><option value = '6.04.01'> 6.04.01 BEBAN BPJS KETENAGAKERJAAN </option><option value = '6.04.02'> 6.04.02 BEBAN BPJS KESEHATAN </option><option value = '6.05.01'> 6.05.01 BEBAN THR </option><option value = '6.05.02'> 6.05.02 BEBAN BONUS </option><option value = '6.06.01'> 6.06.01 BEBAN MANFAAT KARYAWAN </option><option value = '6.10.01'> 6.10.01 BEBAN PROMOSI DAN IKLAN </option><option value = '6.11.01'> 6.11.01 BEBAN EKSPEDISI ANGKUTAN </option><option value = '6.12.01'> 6.12.01 BEBAN EKSPOR </option><option value = '6.12.02'> 6.12.02 BEBAN LC </option><option value = '6.13.01'> 6.13.01 BEBAN PIUTANG TIDAK TERTAGIH </option><option value = '6.14.01'> 6.14.01 BEBAN KLAIM PENJUALAN </option><option value = '6.14.02'> 6.14.02 BEBAN PINALTI PENJUALAN </option><option value = '6.14.03'> 6.14.03 BEBAN KOMISI PENJUALAN </option><option value = '6.15.01'> 6.15.01 BEBAN SAMPEL </option><option value = '6.15.02'> 6.15.02 BEBAN ENTERTAINMENT </option><option value = '6.16.01'> 6.16.01 BEBAN PEMELIHARAAN BANGUNAN </option><option value = '6.16.11'> 6.16.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK </option><option value = '6.16.12'> 6.16.12 BEBAN PEMELIHARAAN INSTALASI AIR </option><option value = '6.16.21'> 6.16.21 BEBAN PEMELIHARAAN MESIN </option><option value = '6.16.41'> 6.16.41 BEBAN PEMELIHARAAN KENDARAAN </option><option value = '6.16.51'> 6.16.51 BEBAN PEMELIHARAAN PERALATAN KANTOR </option><option value = '6.17.01'> 6.17.01 BEBAN PENYUSUTAN BANGUNAN </option><option value = '6.17.11'> 6.17.11 BEBAN PENYUSUTAN INSTALASI LISTRIK </option><option value = '6.17.12'> 6.17.12 BEBAN PENYUSUTAN INSTALASI AIR </option><option value = '6.17.21'> 6.17.21 BEBAN PENYUSUTAN MESIN </option><option value = '6.17.41'> 6.17.41 BEBAN PENYUSUTAN KENDARAAN </option><option value = '6.17.51'> 6.17.51 BEBAN PENYUSUTAN PERALATAN KANTOR </option><option value = '6.17.52'> 6.17.52 BEBAN PENYUSUTAN PERALATAN IT </option><option value = '6.17.91'> 6.17.91 BEBAN AMORTISASI PERANGKAT LUNAK </option><option value = '6.18.01'> 6.18.01 BEBAN ASURANSI BANGUNAN </option><option value = '6.18.11'> 6.18.11 BEBAN ASURANSI INSTALASI LISTRIK </option><option value = '6.18.12'> 6.18.12 BEBAN ASURANSI INSTALASI AIR </option><option value = '6.18.21'> 6.18.21 BEBAN ASURANSI MESIN </option><option value = '6.18.41'> 6.18.41 BEBAN ASURANSI KENDARAAN </option><option value = '6.18.51'> 6.18.51 BEBAN ASURANSI PERALATAN KANTOR </option><option value = '6.19.01'> 6.19.01 BEBAN KEPERLUAN KANTOR </option><option value = '6.19.02'> 6.19.02 BEBAN PEMAKAIAN ATK </option><option value = '6.19.03'> 6.19.03 BEBAN FOTOKOPI </option><option value = '6.20.01'> 6.20.01 BEBAN TRAINING KARYAWAN </option><option value = '6.21.01'> 6.21.01 BEBAN TRANSPORTASI </option><option value = '6.21.02'> 6.21.02 BEBAN PERJALANAN DINAS </option><option value = '6.22.01'> 6.22.01 BEBAN RUMAH TANGGA KANTOR </option><option value = '6.23.01'> 6.23.01 BEBAN PERIZINAN </option><option value = '6.23.02'> 6.23.02 BEBAN RETRIBUSI </option><option value = '6.23.03'> 6.23.03 BEBAN IURAN </option><option value = '6.23.04'> 6.23.04 BEBAN SUMBANGAN </option><option value = '6.24.01'> 6.24.01 BEBAN SEWA KANTOR </option><option value = '6.25.01'> 6.25.01 BEBAN LISTRIK KANTOR </option><option value = '6.26.01'> 6.26.01 BEBAN TELEPON KANTOR </option><option value = '6.26.02'> 6.26.02 BEBAN INTERNET KANTOR </option><option value = '6.28.01'> 6.28.01 BEBAN JASA PROFESIONAL </option><option value = '6.27.01'> 6.27.01 BEBAN AIR KANTOR </option><option value = '6.29.01'> 6.29.01 BEBAN PENJUALAN LAINNYA </option><option value = '7.30.01'> 7.30.01 BEBAN GAJI & UPAH </option><option value = '7.31.01'> 7.31.01 BEBAN TUNJANGAN </option><option value = '7.32.01'> 7.32.01 BEBAN LEMBUR </option><option value = '7.33.01'> 7.33.01 BEBAN BPJS KETENAGAKERJAAN </option><option value = '7.33.02'> 7.33.02 BEBAN BPJS KESEHATAN </option><option value = '7.34.01'> 7.34.01 BEBAN THR </option><option value = '7.34.02'> 7.34.02 BEBAN BONUS </option><option value = '7.35.01'> 7.35.01 BEBAN MANFAAT KARYAWAN </option><option value = '7.40.01'> 7.40.01 BEBAN PAJAK </option><option value = '7.41.01'> 7.41.01 BEBAN JASA PROFESIONAL </option><option value = '7.42.01'> 7.42.01 BEBAN ENTERTAINMENT </option><option value = '7.43.01'> 7.43.01 BEBAN SEWA KANTOR </option><option value = '7.43.02'> 7.43.02 BEBAN SEWA PERALATAN KANTOR </option><option value = '7.44.01'> 7.44.01 BEBAN LISTRIK KANTOR </option><option value = '7.45.01'> 7.45.01 BEBAN TELEPON KANTOR </option><option value = '7.45.02'> 7.45.02 BEBAN INTERNET KANTOR </option><option value = '7.46.01'> 7.46.01 BEBAN AIR KANTOR </option><option value = '7.47.01'> 7.47.01 BEBAN PEMELIHARAAN BANGUNAN </option><option value = '7.47.11'> 7.47.11 BEBAN PEMELIHARAAN INSTALASI LISTRIK </option><option value = '7.47.12'> 7.47.12 BEBAN PEMELIHARAAN INSTALASI AIR </option><option value = '7.47.21'> 7.47.21 BEBAN PEMELIHARAAN MESIN </option><option value = '7.47.41'> 7.47.41 BEBAN PEMELIHARAAN KENDARAAN </option><option value = '7.47.51'> 7.47.51 BEBAN PEMELIHARAAN PERALATAN KANTOR </option><option value = '7.48.01'> 7.48.01 BEBAN PENYUSUTAN BANGUNAN </option><option value = '7.48.11'> 7.48.11 BEBAN PENYUSUTAN INSTALASI LISTRIK </option><option value = '7.48.12'> 7.48.12 BEBAN PENYUSUTAN INSTALASI AIR </option><option value = '7.48.21'> 7.48.21 BEBAN PENYUSUTAN MESIN </option><option value = '7.48.41'> 7.48.41 BEBAN PENYUSUTAN KENDARAAN </option><option value = '7.48.51'> 7.48.51 BEBAN PENYUSUTAN PERALATAN KANTOR </option><option value = '7.48.52'> 7.48.52 BEBAN PENYUSUTAN PERALATAN IT </option><option value = '7.48.91'> 7.48.91 BEBAN AMORTISASI PERANGKAT LUNAK </option><option value = '7.49.01'> 7.49.01 BEBAN ASURANSI BANGUNAN </option><option value = '7.49.11'> 7.49.11 BEBAN ASURANSI INSTALASI LISTRIK </option><option value = '7.49.12'> 7.49.12 BEBAN ASURANSI INSTALASI AIR </option><option value = '7.49.21'> 7.49.21 BEBAN ASURANSI MESIN </option><option value = '7.49.41'> 7.49.41 BEBAN ASURANSI KENDARAAN </option><option value = '7.49.51'> 7.49.51 BEBAN ASURANSI PERALATAN KANTOR </option><option value = '7.50.01'> 7.50.01 BEBAN KEPERLUAN KANTOR </option><option value = '7.50.02'> 7.50.02 BEBAN PEMAKAIAN ATK </option><option value = '7.50.03'> 7.50.03 BEBAN FOTOKOPI </option><option value = '7.51.01'> 7.51.01 BEBAN TRAINING KARYAWAN </option><option value = '7.52.01'> 7.52.01 BEBAN TRANSPORTASI </option><option value = '7.52.02'> 7.52.02 BEBAN PERJALANAN DINAS </option><option value = '7.53.01'> 7.53.01 BEBAN RUMAH TANGGA KANTOR </option><option value = '7.54.01'> 7.54.01 BEBAN PERIZINAN </option><option value = '7.54.02'> 7.54.02 BEBAN RETRIBUSI </option><option value = '7.54.03'> 7.54.03 BEBAN IURAN </option><option value = '7.54.04'> 7.54.04 BEBAN SUMBANGAN </option><option value = '7.99.01'> 7.99.01 BEBAN ADMINISTRASI & UMUM LAINNYA </option><option value = '8.01.01'> 8.01.01 LABA / (RUGI) PENJUALAN ASET TETAP </option><option value = '8.02.01'> 8.02.01 PENJUALAN SPAREPARTS </option><option value = '8.03.01'> 8.03.01 PENJUALAN LAIN-LAIN </option><option value = '8.04.01'> 8.04.01 PENDAPATAN JASA GIRO </option><option value = '8.05.01'> 8.05.01 PENDAPATAN SEWA </option><option value = '8.06.01'> 8.06.01 PENDAPATAN LAIN-LAIN </option><option value = '8.50.01'> 8.50.01 BEBAN BUNGA BANK </option><option value = '8.50.02'> 8.50.02 BEBAN BUNGA PEMEGANG SAHAM/DIREKSI </option><option value = '8.50.99'> 8.50.99 BEBAN BUNGA LAIN-LAIN </option><option value = '8.51.01'> 8.51.01 BEBAN ADMINISTRASI BANK </option><option value = '8.51.02'> 8.51.02 BEBAN PROVISI BANK </option><option value = '8.51.03'> 8.51.03 BEBAN ADMINISTRASI REKENING </option><option value = '8.52.01'> 8.52.01 LABA / (RUGI) SELISIH KURS </option><option value = '8.53.01'> 8.53.01 PEMBULATAN </option><option value = '8.54.01'> 8.54.01 BEBAN LAIN-LAIN </option><option value = '9.10.01'> 9.10.01 PAJAK KINI </option><option value = '9.10.02'> 9.10.02 PAJAK TANGGUHAN </option> </select>";
	var cost = "<select class='form-control select2bs4' name='cost' id='cost' style='width: 250px'> <option value='-' > - </option> <option value='01'> CUTTING </option><option value='02'> DISTRIBUTION </option><option value='03'> HEAT SEAL </option><option value='11'> SEWING </option><option value='12'> BARTEX </option><option value='21'> STEAM </option><option value='22'> FINISHING </option><option value='23'> PACKING </option><option value='31'> QUALITY CONTROL </option><option value='32'> MECHANIC </option><option value='33'> PPIC </option><option value='34'> LABORATORY </option><option value='35'> INDUSTRIAL ENGINERING </option><option value='36'> EXPEDITION </option><option value='37'> FABRICS WAREHOUSE </option><option value='38'> ACCESSORIES WAREHOUSE </option><option value='39'> FINISHED GOOD WAREHOUSE </option><option value='40'> SPAREPART WAREHOUSE </option><option value='41'> SPOT CLEANING </option><option value='60'> MANAGEMENT - FACTORY </option><option value='61'> MARKETING - TEAM A </option><option value='62'> MARKETING - TEAM B </option><option value='63'> MARKETING - TEAM C </option><option value='71'> EXPORT & IMPORT </option><option value='72'> PURCHASING </option><option value='73'> RESEARCH & DEVELOPMENT </option><option value='74'> SAMPLE ROOM </option><option value='81'> FINANCE, ACCOUNTING & TAX </option><option value='82'> INTERNAL AUDIT </option><option value='83'> HUMAN RESOURCE & DEVELOPMENT </option><option value='84'> GENERAL AFFAIR </option><option value='85'> INFORMATION TECHNOLOGY </option><option value='86'> COMPLIANCE </option><option value='87'> SYSTEM DEVELOPMENT </option><option value='99'> DIRECTOR </option> </select>";
	    $.ajax({		
		    url: "load_invoice_detail_alo/",							
			type: "GET",
			dataType: "JSON",
			    success: function (response) {
					var trHTML = '';
					$.each(response, function (i, item) {
						trHTML += '<tr>';		
						trHTML += '<td style="width: 300px;">'+coa+"</td>";		
						trHTML += '<td style="width: 300px;">' +cost+ "</td>";
						trHTML += '<td><input type="text" value="'+ item.ref_number +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';
						trHTML += '<td><input type="text" value="'+ item.ref_date +'" class="form-control" id="stylein" name="stylein" style="width: 150px; text-align: center;"  autocomplete="off" readonly></td>';
						trHTML += '<td><input type="text" value="'+ item.due_date +'" class="form-control" id="stylein" name="stylein" style="width: 150px; text-align: center;"  autocomplete="off" readonly></td>';
						trHTML += '<td><input type="text" value="'+ item.total +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';
						trHTML += '<td><input type="text" value="'+ item.eqp_idr +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';
						trHTML += '<td><input type="text" value="'+ item.amount +'" class="form-control" id="stylein" name="stylein" style="width: 180px; text-align: center;"  autocomplete="off" readonly></td>';										    					
						trHTML += '<td ><input type="text" class="form-control" style="width: 300px;text-align: center;" id="desc" name="desc"  autocomplete="off"></td>';											
						trHTML += '</tr>';

				    });
						$('#table-sj').append(trHTML);
                        //Grand Total SO Proforma
						// sum_grandtotal_proforma(); 
													
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
			}
	  });  	  	

}


function save_alokasi() {
	
	simpanalokasi();	
	simpan_alokasi_detail();
	//	
	$('#modal-simpan-alokasi').modal('hide');
	
}


function simpanalokasi() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
						var no_alk 			= $('#alk_number').val();
            var tgl_alk     = $('#alo_date').val();
            var customer    = $('#customer').val();
            var doc_number  = $('#doc_number').val();
            var bank   			= $('#bank').val();
            var account 		= $('#acc').val();
            var curr     		= $('#currn').val();
            var rate        = $('#rate').val();
            var amount      = $('#am_awal').val();
            var eqp_idr     = $('#pl_akhir').val();
            var status      = "POST"
			//			
		   	data.push({		
					"no_alk": no_alk,
					"tgl_alk": tgl_alk,
					"customer": customer,	
					"doc_number": doc_number,					
					"bank": bank,
					"account": account,
					"curr": curr,
					"rate": rate,	
					"amount": amount,					
					"eqp_idr": eqp_idr,
					"status": status,															
				})	
			
			var fdata = {
				'data_table': data,
				'no_alk': no_alk
			}
			$.ajax({				
				url: "simpanalokasi/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					delete_kwt_detail_temporary();
					// Print Preview Invoice
					// let no_kwt= $('[name="kwt_no"]').val();
					// print_kwitansi(no_kwt);
     //                // Reload Page
					window.location.href = window.location.href;

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}


function simpan_alokasi_detail() 
{ 	
	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		

			var table = document.getElementById("table-sj");
			for (var i = 1; i < (table.rows.length); i++) {

				var coa = document.getElementById("table-sj").rows[i].cells[0].children[0].value;
				var cost_center = document.getElementById("table-sj").rows[i].cells[1].children[0].value;
				var no_ref = document.getElementById("table-sj").rows[i].cells[2].children[0].value;
				var ref_date = document.getElementById("table-sj").rows[i].cells[3].children[0].value;
				var due_date = document.getElementById("table-sj").rows[i].cells[4].children[0].value;
				var total = document.getElementById("table-sj").rows[i].cells[5].children[0].value;
				var eqp_idr = document.getElementById("table-sj").rows[i].cells[6].children[0].value;
				var amount = document.getElementById("table-sj").rows[i].cells[7].children[0].value;
				var keterangan = document.getElementById("table-sj").rows[i].cells[8].children[0].value;
				var status      = "POST";
				
				data.push({		
					"no_alk": $('#alk_number').val(),
					"coa": coa,
					"cost_center": cost_center,
					"no_ref": no_ref,	
					"ref_date": ref_date,					
					"due_date":due_date,
					"total": total,
					"eqp_idr": eqp_idr,
					"amount": amount,
					"keterangan": keterangan,
					"status": status,								
																			
				})		
			}
															
			var fdata = {
				'data_table': data
			}

			$.ajax({				
				url: "simpan_alokasi_detail/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					
				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});  
               			
}

function cari_alokasi() { 

	$('#table-kwitansi tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_kwt = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_kwt = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_kwt   = "undefined";
			dt_sampai_kwt = "undefined";
		});

		var customer = $('#customer').val();	
		console.log(dt_sampai_kwt, dt_dari_kwt);

		
							
	$.ajax({		
		url: "cari_alokasi/" + dt_dari_kwt + "/" + dt_sampai_kwt + "/" + customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 								
				trHTML += '<tr>';					
				trHTML += '<td onclick="view_alok(\'' + item.id + '\',\'' + item.no_alk + '\')">' + item.no_alk + "</td>";
				trHTML += '<td>' + item.tgl_alk + "</td>";	
				trHTML += '<td>' + item.supplier + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.bank + "</td>";
				trHTML += '<td>' + item.account + "</td>";	
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + item.rate + "</td>";
				trHTML += '<td>' + item.amount + "</td>";
				trHTML += '<td>' + item.eqp_idr + "</td>";	
				trHTML += '<td><button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_alokasi(' + item.id + ')"><i class="fa fa-print"></i> Print</button> </td>';
				// trHTML += '<td><button type="button" class="btn btn-sm btn-primary swalDefaultError" href="javascript:void(0)" onclick="getType3(\'' + item.supp + '\',\'' + item.no_kwt + '\',\'' + item.total + '\',\'' + item.bilang + '\')">Update</button> ' + '' 
				// + ' <button id="print_inv" name="print_inv" type="button" class="btn btn-primary btn-sm" onclick="print_kwitansi(' + item.id + ')"><i class="fa fa-print"></i> Print</button> ' + ''
				// + ' <button type="button" class="btn btn-sm btn-danger" href="javascript:void(0)" onclick="cancel_kwt(\'' + item.no_kwt + '\', \'' + item.status + '\')">Cancel</button></td> </td>';
				
				trHTML += '</tr>';
			
			});

			$('#table-kwitansi').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}


function view_alok(id, kwt){ 
	
    var no_kwt  = id;

	$('#txt_view').val(kwt);
	// $('#id_kwitansi').val(no_kwt);
	// $('#id_bppb').val(shipp_number);
	cari_view_alokasi(no_kwt);
	// $('#modal-view-kwt').modal('show');  

}

function cari_view_alokasi(no_kwt) { 

	$('#table-view-kwt tbody tr').remove();	
		//Date range picker		
							
	$.ajax({		
		url: "cari_view_alokasi/" + no_kwt + "/" ,					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 								
				trHTML += '<tr>';					
				trHTML += '<td>' + item.coa_name + "</td>";
				trHTML += '<td>' + item.cost_name + "</td>";	
				trHTML += '<td>' + item.supplier + "</td>";
				trHTML += '<td>' + item.no_ref + "</td>";
				trHTML += '<td>' + item.ref_date + "</td>";
				trHTML += '<td>' + item.due_date + "</td>";
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + item.eqp_idr + "</td>";
				trHTML += '<td>' + item.amount + "</td>";
				trHTML += '<td>' + item.ost + "</td>";	
				trHTML += '<td>' + item.keterangan + "</td>";
				trHTML += '</tr>';
				// trHTML += '<td>' + item.curr +' '+ item.total + "</td>";
			
			});


			$('#table-view-kwt').append(trHTML);	
			$('#modal-view-kwt').modal('show');			
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function print_alokasi(id) {

	//var id_bank = $('#bank').val(); 	
	//window.open("http://localhost/ar-nag/arnag/report_invoice/" + id + "/" );  
	//window.open("http://localhost/ar-nag/arnag/report_invoice2/" + id + "/" ); 
	//window.open("http://10.10.2.179/ar-nag/arnag/report_invoice3/" + id + "/" + id_bank + "/" );  	
	window.open(".../../report_invoice5/" + id + "/" );  	
		
}

function cari_kartu_ar() { 

	$('#table-kartu_ar tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_inv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_inv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_inv   = "undefined";
			dt_sampai_inv = "undefined";
		});

		var id_customer = $('#customer').val();	

		
							
	$.ajax({		
		url: "cari_kartu_ar/" + dt_dari_inv + "/" + dt_sampai_inv + "/" + id_customer + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			tot_idr = 0;
			tot_usd = 0;
			sal_idr = 0;
			sal_usd = 0;
			byr_idr = 0;
			byr_usd = 0;
			ahr_usd = 0;
			ahr_idr = 0;
			$.each(response, function (i, item) { 
				if(item.totalidr == null){
				tot_idr = 0;
			}	
			else{
				tot_idr = parseFloat(item.totalidr);
			}

			if(item.totalusd == null){
				tot_usd = 0;
			}	
			else{
				tot_usd = parseFloat(item.totalusd);
			}

			if(item.saldoidr == null){
				sal_idr = 0;
			}	
			else{
				sal_idr = parseFloat(item.saldoidr - item.bayaridr2);
			}

			if(item.saldousd == null){
				sal_usd = 0;
			}	
			else{
				sal_usd = parseFloat(item.saldousd - item.bayarusd2);
			}

			if(item.bayaridr == null){
				byr_idr = 0;
			}	
			else{
				byr_idr = parseFloat(item.bayaridr);
			}

			if(item.bayarusd == null){
				byr_usd = 0;
			}	
			else{
				byr_usd = parseFloat(item.bayarusd);
			}

			ahr_usd = (sal_usd + tot_usd) - byr_usd;
			ahr_idr = (sal_idr + tot_idr) - byr_idr;

				if (item.totalidr == null && item.totalusd == null && item.saldoidr == null && item.saldousd == null && item.bayaridr == null && item.bayarusd == null) {

				}	else{				
			
				trHTML += '<tr>';					
				trHTML += '<td>' + item.namasupplier + "</td>";
				trHTML += '<td>' + formatMoney(sal_usd) + "</td>";	
				trHTML += '<td>' + formatMoney(tot_usd) + "</td>";
				trHTML += '<td>' + formatMoney(byr_usd) + "</td>";
				trHTML += '<td>' + formatMoney(ahr_usd) + "</td>";
				trHTML += '<td>' + formatMoney(sal_idr) + "</td>";
				trHTML += '<td>' + formatMoney(tot_idr) + "</td>";	
				trHTML += '<td>' + formatMoney(byr_idr) + "</td>";	
				trHTML += '<td>' + formatMoney(ahr_idr) + "</td>";
				trHTML += '</tr>';
			}
			});

			$('#table-kartu_ar').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function cari_kartu_ar2() { 

	$('#table-kartu_ar2 tbody tr').remove();	
		//Date range picker
		$('input[name="cobacoba"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="cobacoba"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_alk = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_alk = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="cobacoba"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_alk   = "undefined";
			dt_sampai_alk = "undefined";
		});

		var id_cus = $('#customer').val();	
		console.log(dt_dari_alk + dt_sampai_alk)

		
							
	$.ajax({		
		url: "cari_kartu_ar2/" + dt_dari_alk + "/" + dt_sampai_alk + "/" + id_cus + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			bayar = 0;
			bayar_ = 0;
			sal_awl = 0;
			sal_awl_ = 0;
			tambah = 0;
			tambah_ = 0;
			total = 0;
			total_ = 0;
			byr_idr = 0;
			byr_usd = 0;
			ahr_usd = 0;
			ahr_idr = 0;
			kata = '';
			$.each(response, function (i, item) { 
				if(item.inv_date >= dt_dari_alk){
				sal_awl = 0;
			}	
			else{
				sal_awl = parseFloat(item.amount1 - item.bayar2);
			}

			if(item.inv_date >= dt_dari_alk){
				tambah = parseFloat(item.amount1 - item.bayar2);
			}	
			else{
				tambah = 0;
			}

			sal_awl_ += sal_awl;
			total = (sal_awl + tambah) - item.bayar;
			total_ += total;
			bayar = parseFloat(item.bayar);
			bayar_ += bayar;
			tambah_ += tambah;
			kata = 'Total';


			// ahr_usd = (sal_usd + tot_usd) - byr_usd;
			// ahr_idr = (sal_idr + tot_idr) - byr_idr;

				if (sal_awl == '0' && tambah == '0' && item.bayar == '0' && total == '0') {

				}	else{				
			
				trHTML += '<tr>';					
				trHTML += '<td>' + item.customer + "</td>";
				trHTML += '<td>' + item.no_invoice + "</td>";	
				trHTML += '<td>' + item.inv_date + "</td>";
				trHTML += '<td>' + item.top + "</td>";
				trHTML += '<td>' + item.curr + "</td>";
				trHTML += '<td>' + formatMoney(sal_awl) + "</td>";
				trHTML += '<td>' + formatMoney(tambah) + "</td>";	
				trHTML += '<td>' + formatMoney(item.bayar) + "</td>";	
				trHTML += '<td>' + formatMoney(total) + "</td>";
				trHTML += '</tr>';
			}
			});
			// trHTML += '<tr>';					
			// 	trHTML += '<td colspan="5" style="text-align: center">' +kata+ "</td>";
			// 	trHTML += '<td>' + formatMoney(sal_awl_) + "</td>";
			// 	trHTML += '<td>' + formatMoney(tambah_) + "</td>";	
			// 	trHTML += '<td>' + formatMoney(bayar_) + "</td>";	
			// 	trHTML += '<td>' + formatMoney(total_) + "</td>";
			// 	trHTML += '</tr>';

			$('#table-kartu_ar2').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	

}

function cari_invoice_manual_post(){ 
	
	$('#table-approval-invoice-manual tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});
							
	$.ajax({		
		url: "cari_invoice_manual_post/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";					
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_mnl_approv" id="pilih_inv_mnl_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

			$('#table-approval-invoice-manual').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}


function approve_invoice_manual(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_mnl_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
				var formData = {
					"id_inv": id_inv,			
				};
				//
				$.ajax({						
					url: "approve_invoice_manual/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-approve-invoice-manual').modal('hide');
				console.log(id_inv);  
				// window.location.reload();
				// cari_invoice_post();

				//
		} 
	}
	
}

//  async function refresh(){
//    var result = await approve_invoice()
//    console.log(result);
//    alert("Approve Successfully");
//    cari_invoice_post();
// }

async function refresh_manual(){
   var result = await approve_invoice_manual()
   console.log(result);
   var cek_inv = document.getElementsByName("pilih_inv_mnl_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				var coba = parseInt(i + 1);		
				}
			}
   alert(" Invoice Successfully Approved");
   cari_invoice_manual_post();
}


function modal_show_approve_invoice_manual() { 

	var cek_inv = document.getElementsByName("pilih_inv_mnl_approv");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {				   
			    	$('#modal-approve-invoice-manual').modal('show');  
			} 
	}	
}


function check_approv_invoice_manual(ele) { 

	var checkboxes = document.getElementsByTagName('input');
	if (ele.checked) {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox'  && !(checkboxes[i].disabled) ) {
				checkboxes[i].checked = true;
			}
		}
	} else {
		for (var i = 0; i < checkboxes.length; i++) {
			if (checkboxes[i].type == 'checkbox') {
				checkboxes[i].checked = false;
			}
		}
	}
}


function export_kartu_ar2() { 		
	var id_cus = $('#customer').val();	
	window.open(".../../export_excel_kartu_ar2/" + dt_dari_alk  + "/" + dt_sampai_alk  + "/" + "/" + id_cus + "/" ); 
}

function export_kartu_ar() { 		
	var id_customer = $('#customer').val();	
	window.open(".../../export_excel_kartu_ar/" + dt_dari_inv  + "/" + dt_sampai_inv  + "/" + "/" + id_customer + "/" ); 
}


function cari_invoice_appv(){ 
	
	$('#table-approval-invoice tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});
							
	$.ajax({		
		url: "cari_invoice_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";					
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_reverse" id="pilih_inv_approv" class="flat" value = ' + item.id + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

			$('#table-approval-invoice').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}


function modal_show_reverse_invoice() { 

	var cek_inv = document.getElementsByName("pilih_inv_reverse");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {				   
			    	$('#modal-reverse-invoice').modal('show');  
			} 
	}	
}

function modal_show_reverse_alokasi() { 

	var cek_inv = document.getElementsByName("pilih_alokasi_approv");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {				   
			    	$('#modal-reverse-alokasi').modal('show');  
			} 
	}	
}


async function refresh_rvs(){
   var result = await rvs_invoice()
   console.log(result);
   var cek_inv = document.getElementsByName("pilih_inv_reverse");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				var coba = parseInt(i + 1);		
				}
			}
   alert("Invoice Successfully Reverse");
   // cari_invoice_appv();
}

async function refresh_rvs_alk(){
   var result = await rvs_alokasi()
   console.log(result);
   var cek_inv = document.getElementsByName("pilih_alokasi_approv");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				var coba = parseInt(i + 1);		
				}
			}
   alert("Alokasi Successfully Reverse");
   // cari_invoice_appv();
}


function rvs_alokasi(){
	//
	var cek_inv = document.getElementsByName("pilih_alokasi_approv");	
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
				var formData = {
					"id_inv": id_inv,
					"keter": keter,			
				};
				//
				$.ajax({						
					url: "rvs_alokasi/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-alokasi').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
		} 
	}
	
}


function rvs_invoice(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_reverse");	
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
				var formData = {
					"id_inv": id_inv,
					"keter": keter,			
				};
				//
				$.ajax({						
					url: "rvs_invoice/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-invoice').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
		} 
	}
	
}


function cari_invoice_manual_appv(){ 
	
	$('#table-approval-invoice-manual tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});
							
	$.ajax({		
		url: "cari_invoice_manual_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_invoice + "</td>";					
				trHTML += '<td>' + item.customer + "</td>";	
				trHTML += '<td>' + item.shipp + "</td>";
				trHTML += '<td>' + item.doc_type + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.inv_date + "</td>";	
				trHTML += '<td>' + item.type + "</td>";	
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_inv_mnl_rvs" id="pilih_inv_mnl_approv" class="flat" value = ' + item.no_invoice + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

			$('#table-approval-invoice-manual').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}


function modal_show_reverse_invoice_manual() { 

	var cek_inv = document.getElementsByName("pilih_inv_mnl_rvs");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {				   
			    	$('#modal-reverse-invoice-manual').modal('show');  
			} 
	}	
}


async function refresh_manual_rvs(){
   var result = await reverse_invoice_manual()
   console.log(result);
   var cek_inv = document.getElementsByName("pilih_inv_mnl_rvs");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				var coba = parseInt(i + 1);		
				}
			}
   alert(" Invoice Successfully Reverse");
   // cari_invoice_manual_appv();
}


function reverse_invoice_manual(){
	//
	var cek_inv = document.getElementsByName("pilih_inv_mnl_rvs");
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
				var formData = {
					"id_inv": id_inv,
					"keter": keter,			
				};
				//
				$.ajax({						
					url: "reverseinvoice_manual/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-invoice-manual').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
		} 
	}
	
}


function cari_kwt_appv(){ 
	
	$('#table-kwt-rvs tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});
							
	$.ajax({		
		url: "cari_kwt_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_kwt + "</td>";					
				trHTML += '<td>' + item.tgl_kwt + "</td>";	
				trHTML += '<td>' + item.supp + "</td>";
				trHTML += '<td>' + item.curr + ' '+ item.total + "</td>";
				trHTML += '<td>' + item.bilang + "</td>";
				trHTML += '<td>' + item.status + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_kwt_rvs" id="pilih_kwt_rvs" class="flat" value = ' + item.no_kwt + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

			$('#table-kwt-rvs').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}

function modal_show_reverse_kwt() { 

	var cek_inv = document.getElementsByName("pilih_kwt_rvs");	
	for (var i = 0; i < cek_inv.length; i++) {
		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {				   
			    	$('#modal-reverse-kwt').modal('show');  
			} 
	}	
}

async function refresh_rvs_kwt(){
   var result = await reverse_kwt()
   console.log(result);
   var cek_inv = document.getElementsByName("pilih_kwt_rvs");	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				var coba = parseInt(i + 1);		
				}
			}
   alert(" Invoice Successfully Reverse");
   // cari_invoice_manual_appv();
}


function reverse_kwt(){
	//
	var cek_inv = document.getElementsByName("pilih_kwt_rvs");
	var keter = $('[name="keter"]').val()	
	for (var i = 0; i < cek_inv.length; i++) {

		    //Ceklist Invoice		
       		if (cek_inv[i].checked) {	
				//   
				var id_inv = cek_inv[i].value
                //
				var formData = {
					"id_inv": id_inv,
					"keter": keter,			
				};
				//
				$.ajax({						
					url: "reverse_kwt/",		
					type: "POST",	
					data: formData,			
					dataType: "JSON",
					success: function (data) {		
								
						if (data.status) //if success close modal and reload ajax table
						{
							msg = 'Success Update Invoice Approve'
						} else {
							msg = 'Error Update Invoice Approve'
						}
					},
					error: function (jqXHR, textStatus, errorThrown) {
						msg = 'Error Update Invoice Header' + jqXHR.text
					}
				});   	
				//
				$('#modal-reverse-kwt').modal('hide');
				console.log(id_inv);  
				window.location.reload();
				// cari_invoice_post();

				//
		} 
	}
	
}


function cari_alokasi_appv(){ 
	
	$('#table-alokasi-rvs tbody tr').remove();	
		//Date range picker
		$('input[name="reservation2"]').daterangepicker({
			autoUpdateInput: false,
			locale: {
				cancelLabel: 'Clear'
			}
		});
	
		$('input[name="reservation2"]').on('apply.daterangepicker', function (ev, picker) {
			dt_dari_approv = picker.startDate.format('YYYY-MM-DD');
			dt_sampai_approv = picker.endDate.format('YYYY-MM-DD');
			$(this).val(picker.startDate.format('MM/DD/YYYY') + ' - ' + picker.endDate.format('MM/DD/YYYY'));
		});
	
		$('input[name="reservation2"]').on('cancel.daterangepicker', function (ev, picker) {
			$(this).val('');
			dt_dari_approv   = "undefined";
			dt_sampai_approv = "undefined";
		});
							
	$.ajax({		
		url: "cari_alokasi_appv/" + dt_dari_approv + "/" + dt_sampai_approv + "/",					
		type: "GET",
		dataType: "JSON",
		success: function (response) {
										
			var trHTML = '';
			$.each(response, function (i, item) { 					
				trHTML += '<tr>';					
				trHTML += '<td>' + item.no_alk + "</td>";					
				trHTML += '<td>' + item.tgl_alk + "</td>";	
				trHTML += '<td>' + item.supplier + "</td>";
				trHTML += '<td>' + item.doc_number + "</td>";
				trHTML += '<td>' + item.bank + "</td>";	
				trHTML += '<td>' + item.account + "</td>";	
				trHTML += '<td>' + item.curr + "</td>";	
				trHTML += '<td>' + item.amount + "</td>";	
				trHTML += '<td>' + item.id + "</td>";					
				trHTML += '<td style="text-align:center"><input type="checkbox" name="pilih_alokasi_approv" id="pilih_alokasi_approv" class="flat" value = ' + item.no_alk + '></td>';										
				//trHTML += '<td><button id="approv_inv" name="approv_inv" type="button" class="btn btn-warning btn-sm" onclick="approve_invoice(\'' + item.no_invoice + '\' , \'' + item.id + '\')"><i class="fa fa-stamp"></i> Approved</td>';
				trHTML += '</tr>';

			});

			$('#table-alokasi-rvs').append(trHTML);				
			
		},
		error: function (jqXHR, textStatus, errorThrown) {
			alert('Error get data from ajax');
		}
	});	
}



function simpankwitansi() { 

	return new Promise(resolve => {		
		setTimeout(() => {
			var msg
			var data = [];		
            //
			var no_kwt 		= $('#kwt_number').val();
            var tgl_kwt     = $('#kwt_date').val();
            var supp        = $('#customer').val();
            var total       = $('#total').val();
            var terbilang   = $('#terbilang').val();
            var status      = "POST"
			//			
		   	data.push({		
					"no_kwt": no_kwt,
					"tgl_kwt": tgl_kwt,
					"supp": supp,	
					"total": total,					
					"terbilang": terbilang,
					"status": status,															
				})	
			
			var fdata = {
				'data_table': data
			}
			$.ajax({				
				url: "simpankwitansi/",
				type: "POST",
				data: fdata,
				dataType: "JSON",
				success: function (data) {
					
					if (data.status) //if success close modal and reload ajax table
					{
						msg = 'Success Input Detail'
					} else {
						msg = 'Error Input Detail'
					}
					// Delete Table Invoice Detail Temporary
					delete_kwt_detail_temporary();
					// Print Preview Invoice
					let no_kwt= $('[name="kwt_no"]').val();
					print_kwitansi(no_kwt);
                    // Reload Page
					window.location.href = window.location.href;

				},
				error: function (jqXHR, textStatus, errorThrown) {
					msg = 'Error Input Detail' + jqXHR.text
				}
			});
			resolve({
				msg: msg,
			});

		}, 100);
	});

}

