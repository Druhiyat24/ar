<table class="table table-striped" width="100%">
                                    <thead>
                                        <tr>
                                            <th style="text-align: left;font-size: 1rem;" scope="col">Customer</th>
                                            <th style="text-align: left;" scope="col">Value</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 1; 
                                              $jml = 0; ?>
                                        <?php foreach ($events as $dp) : ?>
                                            <?php $jml += $dp['data']; ?>
                                            <tr>
                                                <td style="text-align: left;font-size: 0.9rem;color: #2F4F4F"><?= $dp['customer']; ?></td>
                                                <td style="text-align: right;font-size: 0.9rem;color: #2F4F4F">IDR <?= number_format($dp['data'],2); ?></td>
                                            </tr>
                                            <?php $i++; ?>
                                        <?php endforeach; ?>
                                        <tr>
                                            <th style="text-align: left;font-size: 1rem;" scope="col">Total Overdue <?= $judul; ?> :</th>
                                            <th style="text-align: right;font-size: 1rem;" scope="col">IDR <?= number_format($jml,2); ?></th>
                                        </tr>
                                    </tbody>
                                </table>