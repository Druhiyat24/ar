-- Perbaikan: masterrate sekarang bisa 2 baris per tanggal (kolom curr baru, mis. EUR).
-- Semua lookup rate PAJAK/HARIAN yang tidak filter curr ditambah AND curr = 'USD'.
-- Dijalankan aman: DROP + CREATE ulang 7 procedure ini (nama & isi lain tidak berubah).

DROP PROCEDURE IF EXISTS `ar_get_data_dashboard`;
DELIMITER $$
CREATE DEFINER=`root`@`localhost` PROCEDURE `ar_get_data_dashboard`()
BEGIN
SET @batch = DATE_FORMAT(NOW(), '%Y%m%d%H%i');

INSERT INTO ar_dashboard
(type, profit_center, id_customer, customer, qty, uom, total, avg_price, batch_id)
select type, profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price, @batch from (select 'sales_ytd_invoiced' type, 'NAG' profit_center,customer_invoice id_customer, b.supplier customer, SUM(qty_invoice) qty, satuan_invoice uom, ROUND(SUM(total_invoice * IFNULL(rate,1)),2) total, ROUND(SUM(total_invoice * IFNULL(rate,1))/SUM(qty_invoice),2) avg_price from bppb a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer_invoice left JOIN (select tanggal, curr, rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.bppbdate and c.curr = a.curr_invoice WHERE bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() and total_invoice is not null GROUP BY id_customer
    UNION ALL
    select 'sales_ytd_invoiced' type, 'NAG' profit_center,a.customer, c.Supplier customer, if(uom='PCS',round(sum(qty),0),round(sum(qty),2)) qty, uom, round(sum(total),2) total, round(sum(total)/sum(qty),2) avg_price from tbl_invoice_nb a inner join tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer INNER JOIN (select no_inv, sum(qty) qty, uom from tbl_invoice_nb_detail GROUP BY no_inv) d on d.no_inv = a.no_inv where a.type = 'Commercial' and a.status  IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.inv_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() GROUP BY a.customer
    UNION
    SELECT 'sales_ytd_invoiced' type, 'NAK' profit_center,id_customer, customer, if(uom='PCS',round(qty,0),round(qty,2)) qty, uom, round(total,2) total, round(total/qty,2) avg_price from (SELECT id_customer, customer,sum(qty) qty, sum(eqv_idr) total, uom from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,grand_total total,uom from tbl_book_invoice a inner join tbl_invoice_pot_knitting b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer
        INNER JOIN (select id_book_invoice, uom from tbl_invoice_detail_knitting where id_book_invoice is not null GROUP BY id_book_invoice) di on di.id_book_invoice = a.id where a.id_type = '1' and a.status IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.profit_center = 'NAK' and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.sj_date LEFT JOIN
    (select id_book_invoice,sum(qty) qty from tbl_invoice_detail_knitting where id_book_invoice is not null GROUP BY id_book_invoice) c on c.id_book_invoice = a.id) a GROUP BY customer) a order by qty desc) a GROUP BY profit_center, id_customer

UNION ALL		

(SELECT 'sales_cm_invoiced' type, a.* from (SELECT 'NAG' profit_center,customer_invoice id_customer, b.supplier customer, SUM(qty_invoice) qty, satuan_invoice uom, ROUND(SUM(total_invoice * IFNULL(rate,1)),2) total, ROUND(SUM(total_invoice * IFNULL(rate,1))/SUM(qty_invoice),2) avg_price, @batch from bppb a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer_invoice left JOIN (select tanggal, curr, rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.bppbdate and c.curr = a.curr_invoice WHERE bppbdate BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and total_invoice is not null GROUP BY id_customer) a
    UNION ALL
    select 'sales_cm_invoiced' type, 'NAG' profit_center,a.customer, c.Supplier customer, if(uom='PCS',round(sum(qty),0),round(sum(qty),2)) qty, uom, round(sum(total),2) total, round(sum(total)/sum(qty),2) avg_price, @batch from tbl_invoice_nb a inner join tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer INNER JOIN (select no_inv, sum(qty) qty, uom from tbl_invoice_nb_detail GROUP BY no_inv) d on d.no_inv = a.no_inv where a.type = 'Commercial' and a.status  IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.inv_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) GROUP BY a.customer
    UNION
    SELECT 'sales_cm_invoiced' type, 'NAK' profit_center, id_customer, customer, if(uom='PCS',round(qty,0),round(qty,2)) qty, uom, round(total,2) total, round(total/qty,2) avg_price, @batch from (SELECT id_customer, customer,sum(qty) qty, sum(eqv_idr) total, uom from (select id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,grand_total total,uom from tbl_book_invoice a inner join tbl_invoice_pot_knitting b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer
        INNER JOIN (select id_book_invoice, uom from tbl_invoice_detail_knitting where id_book_invoice is not null GROUP BY id_book_invoice) di on di.id_book_invoice = a.id where a.id_type = '1' and a.status IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.profit_center = 'NAK' and a.sj_date BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.sj_date LEFT JOIN
    (select id_book_invoice,sum(qty) qty from tbl_invoice_detail_knitting where id_book_invoice is not null GROUP BY id_book_invoice) c on c.id_book_invoice = a.id) a GROUP BY customer) a order by qty desc)
		
UNION ALL
	
		(SELECT 'sales_ytd_not_invoiced' type, 'NAG' profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price, @batch from ((SELECT id_customer, customer, qty,CONCAT(format(qty,0),' PCS') qty2, total, CONCAT('IDR ',format(total,2)) total2, 'PCS' uom from (SELECT id_customer, customer,sum(qty) qty, sum(eqv_idr) total from (SELECT  id_customer, Supplier customer,bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,qty from (SELECT c.id_supplier id_customer, f.Supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
            d.styleno, e.product_group, e.product_item, b.color, b.size,  
            a.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
            ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM so AS a INNER JOIN 
            so_det AS b ON a.id = b.id_so INNER JOIN 
            bppb AS c ON b.id = c.id_so_det INNER JOIN 
            act_costing AS d ON a.id_cost = d.id INNER JOIN 
            masterproduct AS e ON d.id_product = e.id INNER JOIN
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() and c.not_sales is null AND (c.bppbdate < '2026-08-01' OR (c.bppbdate >= '2026-08-01' AND c.jenis_trans LIKE 'penjualan%')) and c.id_supplier != '1038' AND total_invoice is null and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY customer) a WHERE a.total > 0 order by qty desc)) a GROUP BY customer
						
						UNION ALL
						
SELECT 'sales_ytd_not_invoiced' jenis_data, 'NAK' profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price, @batch from (
         SELECT id_customer, customer, qty,CONCAT(format(qty,2),' ',CONVERT(uom USING utf8mb4)) qty2, total, CONCAT('IDR ',format(total,2)) total2, uom from (SELECT id_customer, customer,sum(qty) qty, sum(eqv_idr) total,uom from (SELECT id_customer, Supplier customer,bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (SELECT c.id_supplier id_customer, f.Supplier,'' no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, '' AS ws,  
            '' styleno, '' product_group, '' product_item, '' color, '' size,  
            c.curr, IFNULL(c.unit_bill_knitting,c.unit) AS uom, IFNULL(c.qty_bill_knitting,c.qty) qty, Round(IFNULL(c.price_bill_knitting,c.price),4) AS unit_price, ROUND(IFNULL(c.qty_bill_knitting,c.qty) * Round(IFNULL(c.price_bill_knitting,c.price),4), 4) AS total_price,  '' id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM bppb c INNER JOIN 
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.jenis_trans = 'Penjualan' and c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') AND c.cancel = 'N' and LEFT(c.bppbno_int,3) = 'OFC' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY customer, uom) a WHERE a.total > 0 order by qty desc
     ) a GROUP BY customer, uom order by qty desc)
		 
		 
UNION ALL

(SELECT 'sales_cm_not_invoiced' type, 'NAG' profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price, @batch from ((SELECT id_customer, customer, qty,CONCAT(format(qty,0),' PCS') qty2, total, CONCAT('IDR ',format(total,2)) total2, 'PCS' uom from (SELECT id_customer, customer,sum(qty) qty, sum(eqv_idr) total from (SELECT  id_customer, Supplier customer,bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,qty from (SELECT c.id_supplier id_customer, f.Supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
            d.styleno, e.product_group, e.product_item, b.color, b.size,  
            a.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
            ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM so AS a INNER JOIN 
            so_det AS b ON a.id = b.id_so INNER JOIN 
            bppb AS c ON b.id = c.id_so_det INNER JOIN 
            act_costing AS d ON a.id_cost = d.id INNER JOIN 
            masterproduct AS e ON d.id_product = e.id INNER JOIN
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.not_sales is null AND (c.bppbdate < '2026-08-01' OR (c.bppbdate >= '2026-08-01' AND c.jenis_trans LIKE 'penjualan%')) and c.id_supplier != '1038' AND total_invoice is null and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY customer) a WHERE a.total > 0 order by qty desc)) a GROUP BY customer
						
						UNION ALL
						
SELECT 'sales_cm_not_invoiced' jenis_data, 'NAK' profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price, @batch from (
         SELECT id_customer, customer, qty,CONCAT(format(qty,2),' ',CONVERT(uom USING utf8mb4)) qty2, total, CONCAT('IDR ',format(total,2)) total2, uom from (SELECT id_customer, customer,sum(qty) qty, sum(eqv_idr) total,uom from (SELECT id_customer, Supplier customer,bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (SELECT c.id_supplier id_customer, f.Supplier,'' no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, '' AS ws,  
            '' styleno, '' product_group, '' product_item, '' color, '' size,  
            c.curr, IFNULL(c.unit_bill_knitting,c.unit) AS uom, IFNULL(c.qty_bill_knitting,c.qty) qty, Round(IFNULL(c.price_bill_knitting,c.price),4) AS unit_price, ROUND(IFNULL(c.qty_bill_knitting,c.qty) * Round(IFNULL(c.price_bill_knitting,c.price),4), 4) AS total_price,  '' id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM bppb c INNER JOIN 
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.jenis_trans = 'Penjualan' and c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') AND c.cancel = 'N' and LEFT(c.bppbno_int,3) = 'OFC' and c.bppbdate BETWEEN (select min(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) and (select max(tanggal) from dim_date where bulan_text = DATE_FORMAT(CURRENT_DATE,'%m') and tahun = DATE_FORMAT(CURRENT_DATE,'%Y')) ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY customer, uom) a WHERE a.total > 0 order by qty desc
     ) a GROUP BY customer, uom order by qty desc)
		 
ON DUPLICATE KEY UPDATE
		customer = VALUES(customer),
    qty = VALUES(qty),
    total = VALUES(total),
		avg_price = VALUES(avg_price),
		batch_id = @batch,
    updated_at = NOW();
		
		
INSERT INTO ar_dashboard
(type, profit_center, id_customer, customer, curr, total, total_idr, total_not_due, total_ready_due, shipp, batch_id)

SELECT 'receivable' type, profit_center, id_customer, customer, curr, SUM(total) total, SUM(eqv_idr) total_idr, SUM(amt_aging_0) not_due, SUM(readydue) ready_due, shipp, @batch FROM (SELECT a.*, ifnull(b.duedate_update,duedate) duedate_update from (select  profit_center, id_customer, customer, no_invoice, inv_date, shipp, duedate, top, curr, if(curr = 'IDR', 1, rate) rate, sal_awl, tambah, bayar,  total, eqv_idr,amt_aging_0,amt_aging_1,amt_aging_2,amt_aging_3,amt_aging_4,amt_aging_5,amt_aging_6,amt_aging_7, tot_aging, readydue, hasil_bln1, hasil_bln2, hasil_bln3, hasil_bln4, hasil_bln5, hasil_bln6, tot_aging tot_jatem from (select a.*, CASE WHEN jml_bln1 > 0 AND Date(duedate) >= CURRENT_DATE() THEN eqv_idr ELSE 0 END AS hasil_bln1,
        CASE WHEN jml_bln2 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln2,
        CASE WHEN jml_bln3 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln3,
        CASE WHEN jml_bln4 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln4,
        CASE WHEN jml_bln5 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln5,
        CASE WHEN jml_bln6 > 0 THEN eqv_idr ELSE 0 END AS hasil_bln6,
        CASE WHEN total <= 0 THEN 0 WHEN Date(duedate) < CURRENT_DATE() THEN eqv_idr ELSE 0 END AS readydue,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top <= 0 THEN eqv_idr ELSE 0 END AS amt_aging_0,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 0  AND diff_top <= 30  THEN eqv_idr ELSE 0 END AS amt_aging_1,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 30 AND diff_top <= 60  THEN eqv_idr ELSE 0 END AS amt_aging_2,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 60 AND diff_top <= 90  THEN eqv_idr ELSE 0 END AS amt_aging_3,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 90 AND diff_top <= 120 THEN eqv_idr ELSE 0 END AS amt_aging_4,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 120 AND diff_top <= 180 THEN eqv_idr ELSE 0 END AS amt_aging_5,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 180 AND diff_top <= 360 THEN eqv_idr ELSE 0 END AS amt_aging_6,
        CASE WHEN total <= 0 THEN 0 WHEN diff_top > 360 THEN eqv_idr ELSE 0 END AS amt_aging_7,
        CASE WHEN total <= 0 THEN 0 ELSE eqv_idr END AS tot_aging
        from (select a.*, ((sal_awl + tambah) - bayar) total, IF(curr = 'USD',((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0)) * rate,((sal_awl + COALESCE(tambah,0)) - COALESCE(bayar,0))) eqv_idr from (select profit_center, no_invoice, kode_customer, customer, inv_date, id_customer, curr, top, amount1, duedate, bayar, bayar2, rate, shipp, diff_top, ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, IF(inv_date >= CURRENT_DATE(),0,COALESCE(amount1,0) - COALESCE(bayar2,0)) sal_awl, IF(inv_date >= CURRENT_DATE(),COALESCE(amount1,0) - COALESCE(bayar2,0),0) tambah from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT profit_center, no_invoice,kode_customer, customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT profit_center, no_invoice,kode_customer,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,CASE WHEN bayar > 0 AND profit_center = 'NAK' THEN amount1 ELSE bayar END bayar,no_invoice2, CASE WHEN bayar2 > 0 AND profit_center = 'NAK' THEN amount1 ELSE bayar2 END bayar2,rate,shipp,DATEDIFF(CURRENT_DATE(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(CURRENT_DATE(),'%m') fil_bln1,LPAD(DATE_FORMAT(CURRENT_DATE(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(CURRENT_DATE(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(CURRENT_DATE(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(CURRENT_DATE(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(CURRENT_DATE(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(CURRENT_DATE(),'%Y') fil_thn, IF(duedate <= CURRENT_DATE(),amount1,0) ready_due from 
            (SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                FROM  tbl_book_invoice AS a INNER JOIN 
                mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
                tbl_master_top AS f ON a.id_top = f.id left join 
                tbl_duedate AS h ON a.id = h.id_invoice
                where a.sj_date between '2022-05-01' and CURRENT_DATE() and a.profit_center = 'NAG'
                UNION
                SELECT distinct a.profit_center, a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                FROM  tbl_book_invoice AS a INNER JOIN 
                mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
                tbl_master_top AS f ON a.id_top = f.id left join 
                tbl_duedate AS h ON a.id = h.id_invoice
                where a.sj_date between '2022-05-01' and CURRENT_DATE() and a.profit_center = 'NAK'
                UNION
                SELECT distinct 'NAG' profit_center, a.no_inv AS no_invoice, UPPER(b.supplier) AS customer, UPPER(b.supplier_code) kode_customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
                FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
                FROM  tbl_invoice_nb AS a INNER JOIN 
                mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
                tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
                tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
                tbl_duedate AS h ON a.id = h.id_invoice left join
                saldoawal_ar as g on g.no_invoice = a.no_inv
                where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and CURRENT_DATE()
                union                                                                     
                select 'NAG' profit_center, no_invoice, customer, UPPER(b.supplier_code) kode_customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar a INNER JOIN mastersupplier AS b ON a.id_customer = b.id_supplier where no_invoice not like '%DN/%') inv LEFT JOIN
            (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between CURRENT_DATE() and CURRENT_DATE() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
            (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < CURRENT_DATE() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
            (select IF((select id from tbl_tgl_tb where tgl_akhir = CURRENT_DATE()) != '',(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = 'HARIAN' AND curr = 'USD'),(select rate from masterrate where tanggal = CURRENT_DATE() and v_codecurr = 'PAJAK' AND curr = 'USD')) rate) rt) a) a) a) a) a) a WHERE sal_awl > 0 OR tambah > 0 OR bayar > 0 OR total > 0) a LEFT JOIN (select no_invoice, max(duedate_update) duedate_update from tbl_duedate_update_det where status = 'Y' GROUP BY no_invoice) b on b.no_invoice = a.no_invoice) a GROUP BY profit_center, id_customer
		 
ON DUPLICATE KEY UPDATE
		customer = VALUES(customer),
		shipp = VALUES(shipp),
    total = VALUES(total),
		total_idr = VALUES(total_idr),
		total_not_due = VALUES(total_not_due),
		total_ready_due = VALUES(total_ready_due),
		batch_id = @batch,
    updated_at = NOW();
		
		
		
INSERT INTO ar_dashboard
(type, profit_center, shipp, curr, total, batch_id)
SELECT IF(shipp = 'Local','ar_lokal','ar_ekspor') type, profit_center, shipp, 'IDR' curr, Coalesce(sum(eqv_idr),0) total, @batch from (select profit_center, shipp, id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (SELECT 'NAG' profit_center,shipp_invoice shipp, customer_invoice id_customer, '-' status, id_invoice_ar id, b.supplier customer, id_invoice_ar no_invoice, bppbdate sj_date, '1' id_type, curr_invoice curr, total_invoice total from bppb a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer_invoice WHERE bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() and total_invoice is not null 
UNION ALL
select a.profit_center, a.shipp, a.customer, a.status, a.id, c.Supplier customer, a.no_inv, a.inv_date, type, 'IDR' curr, total from tbl_invoice_nb a INNER JOIN tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer where a.type = 'Commercial' and a.status  IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.inv_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()	
        UNION ALL
        select a.profit_center, a.shipp, a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,grand_total total from tbl_book_invoice a inner join tbl_invoice_pot_knitting b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.profit_center = 'NAK' and a.status IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.sj_date) a GROUP BY profit_center, shipp
ON DUPLICATE KEY UPDATE
		shipp = VALUES(shipp),
    total = VALUES(total),
		batch_id = @batch,
    updated_at = NOW();
		


INSERT INTO ar_dashboard
(type, profit_center, shipp, curr, total, batch_id)

select * from (SELECT IF(area = 'Local','ar_lokal_ni','ar_ekspor_ni') type, 'NAG' profit_center, area shipp, 'IDR' curr, COALESCE(sum(eqv_idr),0) total, @batch from (SELECT bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr, area from (SELECT if(f.area = 'I','Export','Local') area,f.supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
            d.styleno, e.product_group, e.product_item, b.color, b.size,  
            a.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
            ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM so AS a INNER JOIN 
            so_det AS b ON a.id = b.id_so INNER JOIN 
            bppb AS c ON b.id = c.id_so_det INNER JOIN 
            act_costing AS d ON a.id_cost = d.id INNER JOIN 
            masterproduct AS e ON d.id_product = e.id INNER JOIN
            mastersupplier f on f.Id_Supplier = c.id_supplier
            WHERE c.not_sales is null AND (c.bppbdate < '2026-08-01' OR (c.bppbdate >= '2026-08-01' AND c.jenis_trans LIKE 'penjualan%')) and c.id_supplier not in ('1038','1384') AND total_invoice is null and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY a.area
						
						UNION ALL
						
SELECT IF(area = 'Local','ar_lokal_ni','ar_ekspor_ni') type, 'NAK' profit_center, area shipp, 'IDR' curr, COALESCE(sum(eqv_idr),0) total, @batch from (SELECT bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,area from (SELECT if(f.area = 'I','Export','Local') area,f.supplier,'' no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, '' AS ws,  
            '' styleno, '' product_group, '' product_item, '' color, '' size,  
            c.curr, IFNULL(c.unit_bill_knitting,c.unit) AS uom, IFNULL(c.qty_bill_knitting,c.qty) qty, Round(IFNULL(c.price_bill_knitting,c.price),4) AS unit_price, ROUND(IFNULL(c.qty_bill_knitting,c.qty) * Round(IFNULL(c.price_bill_knitting,c.price),4), 4) AS total_price,  '' id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM bppb c INNER JOIN 
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.jenis_trans = 'Penjualan' and c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') AND c.cancel = 'N' and LEFT(c.bppbno_int,3) = 'OFC' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY a.area) a
		 
ON DUPLICATE KEY UPDATE
		shipp = VALUES(shipp),
    total = VALUES(total),
		batch_id = @batch,
    updated_at = NOW();
		
		

INSERT INTO ar_dashboard
(type, profit_center, shipp, curr, total, batch_id)

SELECT IF(type_so = 'FOB','ar_fob','ar_cmt') type, profit_center, type_so shipp, 'IDR' curr, Coalesce(sum(eqv_idr),0) total, @batch from (select type_so, profit_center, id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr from (SELECT c.type_so, customer_invoice id_customer, '-' status, id_invoice_ar id, b.supplier customer, id_invoice_ar no_invoice, bppbdate sj_date, '1' id_type, curr_invoice curr, total_invoice total, 'NAG' profit_center from bppb a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer_invoice INNER JOIN tbl_book_invoice c on c.id = a.id_invoice_ar WHERE bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() and total_invoice is not null
        UNION ALL
				select IF(type_so != 'FOB','CMT','FOB') type_so, a.customer, a.status, a.id, c.Supplier customer, a.no_inv, a.inv_date, type, 'IDR' curr, total, a.profit_center from tbl_invoice_nb a INNER JOIN tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer where a.type = 'Commercial' and a.status  IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.inv_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()
				UNION ALL
        select a.type_so, a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,grand_total total, a.profit_center from tbl_book_invoice a inner join tbl_invoice_pot_knitting b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer where a.id_type = '1' and a.status IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.profit_center = 'NAK' and a.sj_date BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE()) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.sj_date) a GROUP BY type_so, profit_center
				UNION ALL
SELECT IF(jns_so = 'FOB','ar_fob_ni','ar_cmt_ni') type, 'NAG' profit_center, jns_so shipp, 'IDR' curr, COALESCE(sum(eqv_idr),0) total, @batch from (SELECT bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr, area, jns_so from (SELECT jns_so,if(f.area = 'I','Export','Local') area,f.supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
            d.styleno, e.product_group, e.product_item, b.color, b.size,  
            a.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
            ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM so AS a INNER JOIN 
            so_det AS b ON a.id = b.id_so INNER JOIN 
            bppb AS c ON b.id = c.id_so_det INNER JOIN 
            act_costing AS d ON a.id_cost = d.id INNER JOIN 
            masterproduct AS e ON d.id_product = e.id INNER JOIN
            mastersupplier f on f.Id_Supplier = c.id_supplier
            WHERE c.not_sales is null AND (c.bppbdate < '2026-08-01' OR (c.bppbdate >= '2026-08-01' AND c.jenis_trans LIKE 'penjualan%')) and c.id_supplier not in ('1038','1384') AND total_invoice is null and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a where a.jns_so is not null GROUP BY a.jns_so
						
						UNION ALL
						
SELECT IF(jns_so = 'FOB','ar_fob_ni','ar_cmt_ni') type, 'NAK' profit_center, jns_so shipp, 'IDR' curr, COALESCE(sum(eqv_idr),0) total, @batch from (SELECT bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,area, jns_so from (SELECT jenis_so_knitting jns_so, if(f.area = 'I','Export','Local') area,f.supplier,'' no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, '' AS ws,  
            '' styleno, '' product_group, '' product_item, '' color, '' size,  
            c.curr, IFNULL(c.unit_bill_knitting,c.unit) AS uom, IFNULL(c.qty_bill_knitting,c.qty) qty, Round(IFNULL(c.price_bill_knitting,c.price),4) AS unit_price, ROUND(IFNULL(c.qty_bill_knitting,c.qty) * Round(IFNULL(c.price_bill_knitting,c.price),4), 4) AS total_price,  '' id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM bppb c INNER JOIN 
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.jenis_trans = 'Penjualan' and c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') AND c.cancel = 'N' and LEFT(c.bppbno_int,3) = 'OFC' and c.bppbdate BETWEEN CONCAT(DATE_FORMAT(CURRENT_DATE,'%Y'),'-01-','01') and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a where a.jns_so is not null GROUP BY a.jns_so	
		 
ON DUPLICATE KEY UPDATE
		shipp = VALUES(shipp),
    total = VALUES(total),
		batch_id = @batch,
    updated_at = NOW();
		
		
		
INSERT INTO ar_dashboard
(type, periode, profit_center, id_customer, customer, qty, uom, total, avg_price, batch_id)
select 'top_buyer_by_sales_value' type, periode, profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price, @batch from ((SELECT 'sales_ytd_invoiced' type, a.* from (SELECT periode, 'NAG' profit_center, id_customer, customer, if(uom='PCS',round(qty,0),round(qty,2)) qty, uom, round(total,2) total, round(total/qty,2) avg_price from (SELECT periode, id_customer, customer,sum(qty) qty, sum(eqv_idr) total, uom from (select DATE_FORMAT(bppbdate,'%Y-%m') periode, customer_invoice id_customer, b.supplier customer, id_invoice_ar no_invoice, bppbdate sj_date, '1' id_type, curr_invoice curr, IFNULL(rate,1) rate, total_invoice total, (total_invoice * IFNULL(rate,1)) eqv_idr, qty_invoice qty, satuan_invoice uom from bppb a INNER JOIN mastersupplier b on b.Id_Supplier = a.customer_invoice left JOIN (select tanggal, curr, rate from masterrate where v_codecurr = 'PAJAK' GROUP BY tanggal) c on c.tanggal = a.bppbdate and c.curr = a.curr_invoice WHERE bppbdate BETWEEN '2020-01-01' and CURRENT_DATE() and total_invoice is not null) a GROUP BY customer, periode) a order by qty desc) a
    UNION ALL
    select 'sales_ytd_invoiced' type, DATE_FORMAT(a.inv_date,'%Y-%m') periode, 'NAG' profit_center,a.customer, c.Supplier customer, if(uom='PCS',round(sum(qty),0),round(sum(qty),2)) qty, uom, round(sum(total),2) total, round(sum(total)/sum(qty),2) avg_price from tbl_invoice_nb a inner join tbl_invoice_nb_pot b on b.no_inv = a.no_inv inner join mastersupplier c on c.Id_Supplier = a.customer INNER JOIN (select no_inv, sum(qty) qty, uom from tbl_invoice_nb_detail GROUP BY no_inv) d on d.no_inv = a.no_inv where a.type = 'Commercial' and a.status  IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.inv_date BETWEEN '2020-01-01' and CURRENT_DATE() GROUP BY a.customer, DATE_FORMAT(a.inv_date,'%Y-%m')
    UNION
    SELECT 'sales_ytd_invoiced' type, periode, 'NAK' profit_center,id_customer, customer, if(uom='PCS',round(qty,0),round(qty,2)) qty, uom, round(total,2) total, round(total/qty,2) avg_price from (SELECT periode, id_customer, customer,sum(qty) qty, sum(eqv_idr) total, uom from (select DATE_FORMAT(sj_date,'%Y-%m') periode, id_customer,customer,no_invoice,sj_date,id_type,curr,IF(curr = 'USD',rate,1) rate,total, round((total * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (select a.id_customer,a.status,a.id,c.Supplier customer,a.no_invoice,a.sj_date,a.id_type,a.curr,grand_total total,uom from tbl_book_invoice a inner join tbl_invoice_pot_knitting b on b.id_book_invoice = a.id inner join mastersupplier c on c.Id_Supplier = a.id_customer
        INNER JOIN (select id_book_invoice, uom from tbl_invoice_detail_knitting where id_book_invoice is not null GROUP BY id_book_invoice) di on di.id_book_invoice = a.id where a.id_type = '1' and a.status IN ('APPROVED','POST','FIRST APPROVED','SECOND APPROVED') and a.profit_center = 'NAK' and a.sj_date BETWEEN '2020-01-01' and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.sj_date LEFT JOIN
    (select id_book_invoice,sum(qty) qty from tbl_invoice_detail_knitting where id_book_invoice is not null GROUP BY id_book_invoice) c on c.id_book_invoice = a.id) a GROUP BY customer, periode) a order by qty desc)
UNION ALL	
(SELECT 'sales_ytd_not_invoiced' type, periode, 'NAG' profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price from ((SELECT periode, id_customer, customer, qty,CONCAT(format(qty,0),' PCS') qty2, total, CONCAT('IDR ',format(total,2)) total2, 'PCS' uom from (SELECT periode, id_customer, customer,sum(qty) qty, sum(eqv_idr) total from (SELECT periode, id_customer, Supplier customer,bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,qty from (SELECT DATE_FORMAT(bppbdate,'%Y-%m') periode, c.id_supplier id_customer, f.Supplier,a.so_no AS no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, d.kpno AS ws,  
            d.styleno, e.product_group, e.product_item, b.color, b.size,  
            a.curr, c.unit AS uom, c.qty, Round(b.price,4) AS unit_price,  
            ROUND(c.qty * Round(b.price,4), 4) AS total_price,  b.id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM so AS a INNER JOIN 
            so_det AS b ON a.id = b.id_so INNER JOIN 
            bppb AS c ON b.id = c.id_so_det INNER JOIN 
            act_costing AS d ON a.id_cost = d.id INNER JOIN 
            masterproduct AS e ON d.id_product = e.id INNER JOIN
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.not_sales is null AND (c.bppbdate < '2026-08-01' OR (c.bppbdate >= '2026-08-01' AND c.jenis_trans LIKE 'penjualan%')) and c.id_supplier != '1038' AND total_invoice is null and c.confirm = 'Y' and c.cancel = 'N' and LEFT(c.bppbno_int,2) = 'FG' and c.bppbdate BETWEEN '2020-01-01' and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY customer) a WHERE a.total > 0 order by qty desc)) a GROUP BY customer, periode
						
						UNION ALL
						
SELECT 'sales_ytd_not_invoiced' jenis_data, periode, 'NAK' profit_center, id_customer, customer, sum(qty) qty, uom, sum(total) total, round(sum(total)/sum(qty),2) avg_price from (
         SELECT periode, id_customer, customer, qty,CONCAT(format(qty,2),' ',CONVERT(uom USING utf8mb4)) qty2, total, CONCAT('IDR ',format(total,2)) total2, uom from (SELECT periode, id_customer, customer,sum(qty) qty, sum(eqv_idr) total,uom from (SELECT periode, id_customer, Supplier customer,bppbdate,curr,total_price,IF(curr = 'USD',rate,1) rate, round((total_price * IF(curr = 'USD',rate,1)),2) eqv_idr,qty, uom from (SELECT DATE_FORMAT(bppbdate,'%Y-%m') periode, c.id_supplier id_customer, f.Supplier,'' no_so, c.bppbno AS sj, c.bppbdate, c.bppbno_int AS shipping_number, '' AS ws,  
            '' styleno, '' product_group, '' product_item, '' color, '' size,  
            c.curr, IFNULL(c.unit_bill_knitting,c.unit) AS uom, IFNULL(c.qty_bill_knitting,c.qty) qty, Round(IFNULL(c.price_bill_knitting,c.price),4) AS unit_price, ROUND(IFNULL(c.qty_bill_knitting,c.qty) * Round(IFNULL(c.price_bill_knitting,c.price),4), 4) AS total_price,  '' id_so, c.id AS id_bppb,if(c.grade = 'GRADE A','A','B') as grade
            FROM bppb c INNER JOIN 
            mastersupplier f on f.id_supplier = c.id_supplier
            WHERE c.jenis_trans = 'Penjualan' and c.not_sales is null and c.id_supplier != '1038' AND (ISNULL(c.stat_inv) OR c.stat_inv = '' or c.stat_inv='0') AND c.cancel = 'N' and LEFT(c.bppbno_int,3) = 'OFC' and c.bppbdate BETWEEN '2020-01-01' and CURRENT_DATE() ) a left JOIN (select tanggal,rate from masterrate where v_codecurr = 'PAJAK' AND curr = 'USD' GROUP BY tanggal) b on b.tanggal = a.bppbdate) a GROUP BY customer, uom) a WHERE a.total > 0 order by qty desc
     ) a GROUP BY customer, uom, periode order by qty desc)) a GROUP BY periode, profit_center, id_customer
		 
ON DUPLICATE KEY UPDATE
		customer = VALUES(customer),
    qty = VALUES(qty),
    total = VALUES(total),
		avg_price = VALUES(avg_price),
		periode = VALUES(periode),
		batch_id = @batch,
    updated_at = NOW();
		
		
CALL get_data_overdue();
CALL get_data_overdue_knitting();
CALL get_data_prediction();
CALL get_data_prediction_knitting();
CALL get_data_sum_ar();
CALL get_data_sum_ar_knitting();

DELETE
FROM ar_dashboard
WHERE batch_id <> @batch
   OR batch_id IS NULL;
	 
	 delete from ar_dashboard_log where logged_at < NOW() - INTERVAL 1 DAY;
	 delete from tbl_data_change_log where created_at < NOW() - INTERVAL 1 DAY;
		
INSERT INTO ar_dashboard_log (logged_at, profit_center, type, customer, uom, avg_price, qty, total, total_idr, total_not_due, total_ready_due)
select NOW(), profit_center, type, customer, uom, avg_price, qty, total, total_idr, total_not_due, total_ready_due from ar_dashboard;



END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_data_overdue`;
DELIMITER $$
CREATE PROCEDURE `get_data_overdue`()
BEGIN

DECLARE i INT DEFAULT 1; 

delete from tbl_data_overdue_ar;

ALTER TABLE tbl_data_overdue_ar AUTO_INCREMENT = 1;

WHILE (i <= 1) DO

    insert into tbl_data_overdue_ar select '',a.* from (SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top < 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= current_date(),eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > current_date(),eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= current_date(),'0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= current_date(),(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF(current_date(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(current_date(),'%m') fil_bln1,LPAD(DATE_FORMAT(current_date(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(current_date(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(current_date(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(current_date(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(current_date(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(current_date(),'%Y') fil_thn, IF(duedate <= current_date(),amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
          FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
          FROM  tbl_book_invoice AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
          tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
          tbl_master_top AS f ON a.id_top = f.id left join 
          tbl_duedate AS h ON a.id = h.id_invoice left join
          saldoawal_ar as g on g.no_invoice = a.no_invoice
          where g.no_invoice is null and a.sj_date between '2023-05-01' and current_date() and a.profit_center = 'NAG'
          union
          SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
          FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
          FROM  tbl_invoice_nb AS a INNER JOIN 
          mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
          tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
          tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
          tbl_duedate AS h ON a.id = h.id_invoice left join
          saldoawal_ar as g on g.no_invoice = a.no_inv
          where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and current_date()
          union                                                                     
          select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar where no_invoice not like '%DN/%') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between current_date() and current_date() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < current_date() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = current_date()) != '',(select rate from masterrate where tanggal = current_date() and v_codecurr = 'HARIAN' AND curr = 'USD'),(select rate from masterrate where tanggal = current_date() and v_codecurr = 'PAJAK' AND curr = 'USD')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp) a;

    SET i = i+1;

END WHILE;

END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_data_overdue_knitting`;
DELIMITER $$
CREATE PROCEDURE `get_data_overdue_knitting`()
BEGIN

DECLARE i INT DEFAULT 1; 

delete from tbl_data_overdue_ar_knitting;

ALTER TABLE tbl_data_overdue_ar_knitting AUTO_INCREMENT = 1;

WHILE (i <= 1) DO

    insert into tbl_data_overdue_ar_knitting select '',a.* from (SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top < 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= current_date(),eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > current_date(),eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= current_date(),'0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= current_date(),(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF(current_date(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(current_date(),'%m') fil_bln1,LPAD(DATE_FORMAT(current_date(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(current_date(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(current_date(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(current_date(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(current_date(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(current_date(),'%Y') fil_thn, IF(duedate <= current_date(),amount1,0) ready_due from 
        (SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
          FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
          FROM  tbl_book_invoice AS a INNER JOIN 
          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
          tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN
          tbl_master_top AS f ON a.id_top = f.id left join 
          tbl_duedate AS h ON a.id = h.id_invoice left join
          saldoawal_ar as g on g.no_invoice = a.no_invoice
          where g.no_invoice is null and a.sj_date between '2023-05-01' and current_date() and a.profit_center = 'NAK') inv LEFT JOIN
        (select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between current_date() and current_date() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
        (select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < current_date() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
        (select IF((select id from tbl_tgl_tb where tgl_akhir = current_date()) != '',(select rate from masterrate where tanggal = current_date() and v_codecurr = 'HARIAN' AND curr = 'USD'),(select rate from masterrate where tanggal = current_date() and v_codecurr = 'PAJAK' AND curr = 'USD')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp) a;

    SET i = i+1;

END WHILE;

END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_data_prediction`;
DELIMITER $$
CREATE PROCEDURE `get_data_prediction`()
BEGIN
DECLARE i INT DEFAULT 0; 
delete from tbl_data_ar_pred;
ALTER TABLE tbl_data_ar_pred AUTO_INCREMENT = 1;
WHILE (i <= 2) DO
    insert into tbl_data_ar_pred select '',DATE_FORMAT(DATE_ADD(current_date(), INTERVAL i month ), '%M %Y') periode, COALESCE(SUM(IF(week = 'week1',eqv_idr,0)),0) ttl_week1,COALESCE(SUM(IF(week = 'week2',eqv_idr,0)),0) ttl_week2,COALESCE(SUM(IF(week = 'week3',eqv_idr,0)),0) ttl_week3,COALESCE(SUM(IF(week = 'week4',eqv_idr,0)),0) ttl_week4, CURRENT_TIMESTAMP() from (select no_invoice,duedate,eqv_idr, CASE
    WHEN DATE_FORMAT(duedate, '%d') >= 1 and DATE_FORMAT(duedate, '%d') <= 7  THEN 'week1'
    WHEN DATE_FORMAT(duedate, '%d') >= 8 and DATE_FORMAT(duedate, '%d') <= 14  THEN 'week2'
    WHEN DATE_FORMAT(duedate, '%d') >= 15 and DATE_FORMAT(duedate, '%d') <= 21  THEN 'week3'
		WHEN DATE_FORMAT(duedate, '%d') >= 22 and DATE_FORMAT(duedate, '%d') <= 31  THEN 'week4'
END as week from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= current_date(),eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > current_date(),eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= current_date(),'0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= current_date(),(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF(current_date(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(current_date(),'%m') fil_bln1,LPAD(DATE_FORMAT(current_date(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(current_date(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(current_date(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(current_date(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(current_date(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(current_date(),'%Y') fil_thn, IF(duedate <= current_date(),amount1,0) ready_due from 
(SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                                          FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                                          tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
                                         tbl_master_top AS f ON a.id_top = f.id left join 
                                          tbl_duedate AS h ON a.id = h.id_invoice left join
                                        saldoawal_ar as g on g.no_invoice = a.no_invoice
                                        where g.no_invoice is null and a.sj_date between '2022-05-01' and current_date() and a.profit_center = 'NAG'
union
SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
                                          FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
                                   FROM  tbl_invoice_nb AS a INNER JOIN 
                                          mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
                                          tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
                                          tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
                                           tbl_duedate AS h ON a.id = h.id_invoice left join
                                        saldoawal_ar as g on g.no_invoice = a.no_inv
                                        where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and current_date()
union                                                                     
select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar where no_invoice not like '%DN/%') inv LEFT JOIN
(select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between current_date() and current_date() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN
(select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < current_date() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN
(select IF((select id from tbl_tgl_tb where tgl_akhir = current_date()) != '',(select rate from masterrate where tanggal = current_date() and v_codecurr = 'HARIAN' AND curr = 'USD'),(select rate from masterrate where tanggal = current_date() and v_codecurr = 'PAJAK' AND curr = 'USD')) rate) rt) a) a) a) a) a where a.total != 0 and DATE_FORMAT(duedate, '%Y-%m') = DATE_FORMAT(DATE_ADD(current_date(), INTERVAL i month ), '%Y-%m')) a ) a;
    SET i = i+1;
END WHILE;
END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_data_prediction_knitting`;
DELIMITER $$
CREATE PROCEDURE `get_data_prediction_knitting`()
BEGIN

DECLARE i INT DEFAULT 0; 

delete from tbl_data_ar_pred_knitting;

ALTER TABLE tbl_data_ar_pred_knitting AUTO_INCREMENT = 1;

WHILE (i <= 2) DO

    insert into tbl_data_ar_pred_knitting select '',DATE_FORMAT(DATE_ADD(current_date(), INTERVAL i month ), '%M %Y') periode, COALESCE(SUM(IF(week = 'week1',eqv_idr,0)),0) ttl_week1,COALESCE(SUM(IF(week = 'week2',eqv_idr,0)),0) ttl_week2,COALESCE(SUM(IF(week = 'week3',eqv_idr,0)),0) ttl_week3,COALESCE(SUM(IF(week = 'week4',eqv_idr,0)),0) ttl_week4, CURRENT_TIMESTAMP() from (select no_invoice,duedate,eqv_idr, CASE

    WHEN DATE_FORMAT(duedate, '%d') >= 1 and DATE_FORMAT(duedate, '%d') <= 7  THEN 'week1'

    WHEN DATE_FORMAT(duedate, '%d') >= 8 and DATE_FORMAT(duedate, '%d') <= 14  THEN 'week2'

    WHEN DATE_FORMAT(duedate, '%d') >= 15 and DATE_FORMAT(duedate, '%d') <= 21  THEN 'week3'

		WHEN DATE_FORMAT(duedate, '%d') >= 22 and DATE_FORMAT(duedate, '%d') <= 31  THEN 'week4'

END as week from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top <= 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= current_date(),eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > current_date(),eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= current_date(),'0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= current_date(),(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF(current_date(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(current_date(),'%m') fil_bln1,LPAD(DATE_FORMAT(current_date(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(current_date(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(current_date(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(current_date(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(current_date(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(current_date(),'%Y') fil_thn, IF(duedate <= current_date(),amount1,0) ready_due from 

(SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,

                                          FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp

                                   FROM  tbl_book_invoice AS a INNER JOIN 

                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 

                                          tbl_type AS c ON a.id_type = c.id_type INNER JOIN

                                          tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN

                                         tbl_master_top AS f ON a.id_top = f.id left join 

                                          tbl_duedate AS h ON a.id = h.id_invoice left join

                                        saldoawal_ar as g on g.no_invoice = a.no_invoice

                                        where g.no_invoice is null and a.sj_date between '2022-05-01' and current_date() and a.profit_center = 'NAK') inv LEFT JOIN

(select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between current_date() and current_date() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN

(select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < current_date() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN

(select IF((select id from tbl_tgl_tb where tgl_akhir = current_date()) != '',(select rate from masterrate where tanggal = current_date() and v_codecurr = 'HARIAN' AND curr = 'USD'),(select rate from masterrate where tanggal = current_date() and v_codecurr = 'PAJAK' AND curr = 'USD')) rate) rt) a) a) a) a) a where a.total != 0 and DATE_FORMAT(duedate, '%Y-%m') = DATE_FORMAT(DATE_ADD(current_date(), INTERVAL i month ), '%Y-%m')) a ) a;

    SET i = i+1;

END WHILE;

END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_data_sum_ar`;
DELIMITER $$
CREATE PROCEDURE `get_data_sum_ar`()
BEGIN

DECLARE i INT DEFAULT 1; 


TRUNCATE TABLE tbl_data_sum_ar2;


ALTER TABLE tbl_data_sum_ar2 AUTO_INCREMENT = 1;

WHILE (i <= 1) DO

    INSERT into tbl_data_sum_ar2 (SELECT '', sum(eqv_idr) ar_eqvidr, sum(ready_due) ready_due, sum(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, CURRENT_TIMESTAMP(), CURRENT_TIMESTAMP() from (SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top < 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= current_date(),eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > current_date(),eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= current_date(),'0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= current_date(),(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp,DATEDIFF(current_date(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(current_date(),'%m') fil_bln1,LPAD(DATE_FORMAT(current_date(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(current_date(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(current_date(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(current_date(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(current_date(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(current_date(),'%Y') fil_thn, IF(duedate <= current_date(),amount1,0) ready_due from 

(SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,
                                          FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp
                                   FROM  tbl_book_invoice AS a INNER JOIN 
                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 
                                          tbl_type AS c ON a.id_type = c.id_type INNER JOIN
                                          tbl_invoice_pot AS d ON a.id = d.id_book_invoice INNER JOIN
                                          tbl_master_top AS f ON a.id_top = f.id left join 
                                          tbl_duedate AS h ON a.id = h.id_invoice left join
                                          saldoawal_ar as g on g.no_invoice = a.no_invoice
                                          where g.no_invoice is null and a.sj_date between '2022-05-01' and current_date() and a.profit_center = 'NAG' and a.status != 'CANCEL'

union

SELECT distinct a.no_inv AS no_invoice, UPPER(b.supplier) AS customer,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS inv_date,DATE_FORMAT(e.sj_date, '%Y-%m-%d') AS tgl_inv, b.Id_Supplier AS id_customer, e.curr,a.top,
                                          FORMAT((d.grand_total), 2) AS amount, if(e.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1, if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(e.sj_date, '%Y-%m-%d'), INTERVAL a.top DAY) ,DATE_ADD(DATE_FORMAT(h.kontrabon_date, '%Y-%m-%d'), INTERVAL a.top DAY)) AS duedate,a.shipp
                                   FROM  tbl_invoice_nb AS a INNER JOIN 
                                          mastersupplier AS b ON a.customer = b.id_supplier INNER JOIN 
                                          tbl_invoice_nb_pot AS d ON a.no_inv = d.no_inv INNER JOIN
                                          tbl_invoice_nb_detail as e on a.no_inv=e.no_inv left JOIN 
                                          tbl_duedate AS h ON a.id = h.id_invoice left join
                                          saldoawal_ar as g on g.no_invoice = a.no_inv
                                          where g.no_invoice is null and a.status != 'CANCEL' and e.sj_date between '2022-05-01' and current_date()

union                                                                     
select no_invoice, customer, inv_date, sj_date as tgl_inv,id_customer, curr, top, FORMAT((grand_total), 2) AS amount, if(curr = 'IDR',round((grand_total),0),round((grand_total), 2)) AS amount1, due_date,shipp from saldoawal_ar where no_invoice not like '%DN/%') inv LEFT JOIN

(select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between current_date() and current_date() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN

(select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < current_date() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN

(SELECT COALESCE(
    IF(
        (SELECT id FROM tbl_tgl_tb WHERE tgl_akhir = CURRENT_DATE()) IS NOT NULL,
        (SELECT rate FROM masterrate WHERE tanggal = CURRENT_DATE() AND v_codecurr = 'HARIAN' AND curr = 'USD'),
        (SELECT rate FROM masterrate WHERE tanggal = CURRENT_DATE() AND v_codecurr = 'PAJAK' AND curr = 'USD')
    ),
    (SELECT rate FROM masterrate WHERE tanggal < CURRENT_DATE() AND v_codecurr IN ('HARIAN','PAJAK') ORDER BY tanggal DESC LIMIT 1)
) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp) a);

    SET i = i+1;

END WHILE;


END$$
DELIMITER ;

DROP PROCEDURE IF EXISTS `get_data_sum_ar_knitting`;
DELIMITER $$
CREATE PROCEDURE `get_data_sum_ar_knitting`()
BEGIN

DECLARE i INT DEFAULT 1; 

delete from tbl_data_sum_ar_knitting;

ALTER TABLE tbl_data_sum_ar_knitting AUTO_INCREMENT = 1;

WHILE (i <= 1) DO

    INSERT into tbl_data_sum_ar_knitting (SELECT '', sum(eqv_idr) ar_eqvidr, sum(ready_due) ready_due, sum(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, CURRENT_TIMESTAMP() from (SELECT shipp,id_customer,customer, curr, IF(curr = 'USD',sum(total),0) foreign_curr, sum(eqv_idr) eqv_idr, SUM(not_due) not_due, SUM(amt_aging_1) amt_aging_1, SUM(amt_aging_2) amt_aging_2, SUM(amt_aging_3) amt_aging_3, SUM(amt_aging_4) amt_aging_4, SUM(amt_aging_5) amt_aging_5, SUM(amt_aging_6) amt_aging_6, SUM(amt_aging_7) amt_aging_7, SUM(tot_aging) tot_aging, SUM(ready_due) ready_due, SUM(jml_bln1) jml_bln1, SUM(jml_bln2) jml_bln2, SUM(jml_bln3) jml_bln3, SUM(jml_bln4) jml_bln4, SUM(jml_bln5) jml_bln5, SUM(jml_bln6) jml_bln6,SUM(tot_aging2) tot_aging2 from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, total, eqv_idr, IF(diff_top < 0,eqv_idr,0) not_due, IF(diff_top > 0 AND diff_top <= 30,eqv_idr,0) amt_aging_1, IF(diff_top > 30 AND diff_top <= 60,eqv_idr,0) amt_aging_2, IF(diff_top > 60 AND diff_top <= 90,eqv_idr,0) amt_aging_3, IF(diff_top > 90 AND diff_top <= 120,eqv_idr,0) amt_aging_4, IF(diff_top > 120 AND diff_top <= 180,eqv_idr,0) amt_aging_5, IF(diff_top > 180 AND diff_top <= 360,eqv_idr,0) amt_aging_6, IF(diff_top > 360,eqv_idr,0) amt_aging_7,eqv_idr tot_aging,IF(duedate <= current_date(),eqv_idr,0) ready_due, IF(jml_bln1 > 0 AND duedate > current_date(),eqv_idr,0) jml_bln1, IF(jml_bln2 > 0,eqv_idr,0) jml_bln2, IF(jml_bln3 > 0,eqv_idr,0) jml_bln3, IF(jml_bln4 > 0,eqv_idr,0) jml_bln4, IF(jml_bln5 > 0,eqv_idr,0) jml_bln5, IF(jml_bln6 > 0,eqv_idr,0) jml_bln6, eqv_idr tot_aging2, id_customer from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, rate, sal_awal,tambah,bayar, ((sal_awal + tambah) - bayar) total, (((sal_awal + tambah) - bayar) * rate) eqv_idr,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6,diff_top,id_customer  from (SELECT customer, no_invoice, inv_date, shipp, duedate, top, curr, IF(curr = 'USD',rate,'1') rate, IF(inv_date >= current_date(),'0',(COALESCE(amount1,0)) - COALESCE(bayar2,0)) sal_awal, IF(inv_date >= current_date(),(COALESCE(amount1,0)) - COALESCE(bayar2,0),'0') tambah, bayar,ready_due, jml_bln1, jml_bln2, jml_bln3, jml_bln4, jml_bln5, jml_bln6, diff_top,id_customer from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,coalesce(bayar,0) bayar,no_invoice2,bayar2,rate,shipp, diff_top,ready_due, IF(bln_due = fil_bln1 and thn_due = fil_thn1,amount1,'0') jml_bln1,IF(bln_due = fil_bln2 and thn_due = fil_thn2,amount1,'0') jml_bln2,IF(bln_due = fil_bln3 and thn_due = fil_thn3,amount1,'0') jml_bln3,IF(bln_due = fil_bln4 and thn_due = fil_thn4,amount1,'0') jml_bln4,IF(bln_due = fil_bln5 and thn_due = fil_thn5,amount1,'0') jml_bln5,IF(bln_due = fil_bln6 and thn_due = fil_thn6,amount1,'0') jml_bln6 from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,bayar,no_invoice2,bayar2,rate,shipp, diff_top, bln_due, thn_due, LPAD(IF(fil_bln1 <= 12,fil_bln1,(fil_bln1 - 12)),2,0) fil_bln1,LPAD(IF(fil_bln2 <= 12,fil_bln2,(fil_bln2 - 12)),2,0) fil_bln2,LPAD(IF(fil_bln3 <= 12,fil_bln3,(fil_bln3 - 12)),2,0) fil_bln3,LPAD(IF(fil_bln4 <= 12,fil_bln4,(fil_bln4 - 12)),2,0) fil_bln4,LPAD(IF(fil_bln5 <= 12,fil_bln5,(fil_bln5 - 12)),2,0) fil_bln5, LPAD(IF(fil_bln6 <= 12,fil_bln6,(fil_bln6 - 12)),2,0) fil_bln6,LPAD(IF(fil_bln1 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn1,LPAD(IF(fil_bln2 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn2,LPAD(IF(fil_bln3 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn3, LPAD(IF(fil_bln4 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn4,LPAD(IF(fil_bln5 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn5, LPAD(IF(fil_bln6 <= 12,fil_thn,(fil_thn + 1)),4,0) fil_thn6, ready_due from (SELECT no_invoice,customer,inv_date,tgl_inv,id_customer,curr,top,amount,amount1,duedate,no_invoice1,if(bayar > 0,amount1, 0) bayar,no_invoice2,if(bayar2 > 0,amount1, 0) bayar2,rate,shipp,DATEDIFF(current_date(),duedate) diff_top, DATE_FORMAT(duedate,'%m') bln_due, DATE_FORMAT(duedate,'%Y') thn_due,DATE_FORMAT(current_date(),'%m') fil_bln1,LPAD(DATE_FORMAT(current_date(),'%m') + 1,2,0) fil_bln2, LPAD(DATE_FORMAT(current_date(),'%m') + 2,2,0) fil_bln3,LPAD(DATE_FORMAT(current_date(),'%m') + 3,2,0) fil_bln4,LPAD(DATE_FORMAT(current_date(),'%m') + 4,2,0) fil_bln5,LPAD(DATE_FORMAT(current_date(),'%m') + 5,2,0) fil_bln6, DATE_FORMAT(current_date(),'%Y') fil_thn, IF(duedate <= current_date(),amount1,0) ready_due from 

(SELECT distinct a.no_invoice AS no_invoice, UPPER(b.supplier) AS customer,a.sj_date inv_date,a.sj_date tgl_inv, b.Id_Supplier AS id_customer, a.curr,f.top,

                                          FORMAT((d.grand_total), 2) AS amount, if(a.curr = 'IDR',round((d.grand_total),0),round((d.grand_total), 2)) AS amount1,if(h.kontrabon_date is null, DATE_ADD(DATE_FORMAT(a.sj_date, '%Y-%m-%d'), INTERVAL f.top DAY) ,DATE_ADD(h.kontrabon_date, INTERVAL f.top DAY)) AS duedate,a.shipp

                                   FROM  tbl_book_invoice AS a INNER JOIN 

                                          mastersupplier AS b ON a.id_customer = b.id_supplier INNER JOIN 

                                          tbl_type AS c ON a.id_type = c.id_type INNER JOIN

                                          tbl_invoice_pot_knitting AS d ON a.id = d.id_book_invoice INNER JOIN

                                         tbl_master_top AS f ON a.id_top = f.id left join 

                                          tbl_duedate AS h ON a.id = h.id_invoice left join

                                        saldoawal_ar as g on g.no_invoice = a.no_invoice

                                        where g.no_invoice is null and a.sj_date between '2022-05-01' and current_date() and a.profit_center = 'NAK' and a.status != 'CANCEL') inv LEFT JOIN

(select a.no_ref as no_invoice1, sum(a.amount) as bayar from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk between current_date() and current_date() and a.total != '0' group by a.no_ref) byr on byr.no_invoice1 = inv.no_invoice LEFT JOIN

(select a.no_ref as no_invoice2, sum(a.amount) as bayar2 from tbl_alokasi_detail a inner join tbl_alokasi b on b.no_alk = a.no_alk where a.status != 'CANCEL' and b.tgl_alk < current_date() and a.total != '0' group by a.no_ref) byr2 on byr2.no_invoice2 = inv.no_invoice JOIN

(select IF((select id from tbl_tgl_tb where tgl_akhir = current_date()) != '',(select rate from masterrate where tanggal = current_date() and v_codecurr = 'HARIAN' AND curr = 'USD'),(select rate from masterrate where tanggal = current_date() and v_codecurr = 'PAJAK' AND curr = 'USD')) rate) rt) a) a) a) a) a ) a GROUP BY a.id_customer,shipp) a);

    SET i = i+1;

END WHILE;

END$$
DELIMITER ;

