<div>
                                    <table id="daily-shot-result" class="table table-striped table-bordered table-hover">
                                        
                                        <thead>
                                            <tr>
                                                <th class="center" style="width: 25px;">#</th>
                                                <th>User Name</th>
                                                <th>Store Name</th>
                                                <th>Payment Method</th>
                                                <th>CNote</th>
                                                <th>Total Payment</th>
                                                <th>Short</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            <?php 
                                             if(isset($shotDetail) && !empty($shotDetail)){
                                            $i=1;
                                            foreach($shotDetail as $shotDetails){

                                            ?>
                                            <tr style="border-bottom: 1px solid;">
                                                <td class="center"><?php echo $i;?></td>

                                                <td><?php echo get_user_name_by_user_ID($shotDetails->user_id); ?></td>
                                                <td><?php
                                                if(isset($shotDetails->store_id) && $shotDetails->store_id != 0) {
                                                    echo getStoreName($shotDetails->store_id);
                                                }
                                                 ?></td>

                                                <td>Cash: <?php echo $shotDetails->cash; ?></br>
                                                    Debit Card: <?php echo $shotDetails->debit_card; ?></br>
                                                    Credit Card: <?php echo $shotDetails->credit_card; ?></br>
                                                    Cheque: <?php echo $shotDetails->cheque; ?></td>

                                                <td><?php echo $shotDetails->cnote; ?></td>
                                                
                                                <td><?php echo $shotDetails->total_payment; ?></td>

                                                <td><?php echo $shotDetails->shot; ?></td>
                                                <td><?php echo date("Y-m-d", strtotime($shotDetails->modify_date));?></td>
                                            </tr>

                                            <?php 
                                            $i++;
                                            } } else { ?>
                                            <tr>
                                                <td colspan="8">No Records</td>
                                            </tr>
                                            <?php } ?>
 
                                        </tbody>
                                    </table>

                                    <script type="text/javascript">
                                      jQuery(document).ready(function() {
                                        <?php  if(isset($shotDetail) && !empty($shotDetail)){ ?>
                                          var oTable1 = $("#daily-shot-result").dataTable({
                                       
                                          "aoColumns": [
                                              { "bSortable": false },
                                              null, null,null, null, null,null, null,
                                            ]
                                          });
                                        <?php } ?>
                                      });
                                    </script>
                                </div>