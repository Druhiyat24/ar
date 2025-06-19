<table class="table table-striped text-nowrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;font-size: 1rem;" scope="col">Customer</th>
                                            <th style="text-align: left;" scope="col">QTY</th>
                                            <th style="text-align: right;" scope="col">Avg Sales Price</th>
                                            <th style="text-align: left;" scope="col">Total Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; 
                                              $jml = 0;
                                              $jml2 = 0; ?>
                                        <?php foreach ($events as $dp) : ?>
                                            <?php   $jml += $dp['qty'];
                                                    $jml2 += $dp['eqv_idr']; ?>
                                            <tr>
                                                <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $dp['customer']; ?></td>
                                                <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F"><?= number_format($dp['qty'],2); ?> PCS</td>
                                                <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F">IDR <?= number_format(($dp['eqv_idr'] / $dp['qty']),2); ?></td>
                                                <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F">IDR <?= number_format($dp['eqv_idr'],2); ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                        <tr>
                                            <th style="text-align: left;font-size: 1rem;" scope="col">Total :</th>
                                            <th style="text-align: right;font-size: 1rem;" scope="col"><?= number_format($jml,2); ?> PCS</th>
                                            <th style="text-align: right;font-size: 1rem;" scope="col"></th>
                                            <th style="text-align: right;font-size: 1rem;" scope="col">IDR <?= number_format($jml2,2); ?></th>
                                        </tr>
                                    </tbody>
                                </table>