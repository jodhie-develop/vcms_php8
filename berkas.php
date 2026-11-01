<?php require_once __DIR__ . "/_lib/bootstrap.php"; auth_require_login(); ?><div class="tab-pane" id="berkas">
               <table width="50%" class="table table-bordered table-striped" id="example1" >
                <thead>
                <tr>
                  <th width="4%" align="center">No</th>
                  <th width="46%">Document Uploaded</th>
                  <th width="25%">Upload Date</th>
                  <th width="25%">By</th>
                  </tr>
                </thead>
                <tbody>

				  <?php 
					if ($result) 
						{ 
						while ($r = db_fetch($result))
							{
							$tgl_enroll = $r[21];
							$kode_biodata = $r[2];
								
							$final_status = $r[10];	
							$query_get_last = q_set($__p_query_get_last, "SELECT update_date FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? order by update_date desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata)]);	
							$result_get_last=db_query_or_die("Wah error nih5", $query_get_last, $__p_query_get_last ?? []);	
							$jumlah_data = db_num_rows($result_get_last);								
							if (num($jumlah_data) > 0 ) 
								{ 
								while ($r_get_last = db_fetch($result_get_last))
									{
							 		$update_terakhir = 	$r_get_last[0];
									$query_get_admission = q_set($__p_query_get_admission, "SELECT dest_school, dest_program, dest_country, h_nh, p_np, bintang, final_status, remark, step, date_format(update_date,'%d/%m/%y') FROM adm_stu_progress where enroll_date = ? and kd_biodata = ? and update_date = ? order by no desc limit 1", [(string) ($tgl_enroll), (string) ($kode_biodata), (string) ($update_terakhir)]);

									$result_get_admission=db_query_or_die("Wah error nih5", $query_get_admission, $__p_query_get_admission ?? []);	
										if ($result_get_admission) 
											{ 
											while ($r_get_admission = db_fetch($result_get_admission))
												{
												$step = "Unknown Step";	
												$r[5] = $r_get_admission[0];
												$r[6] = $r_get_admission[1];
												$r[15] = $r_get_admission[2];
												$r[8] = $r_get_admission[3];
												$r[9] = $r_get_admission[4];
												$r[4] = $r_get_admission[6];
												$r[10] = $r_get_admission[6];
												$r[11] = $r_get_admission[7];
												$step = $r_get_admission[8];											
												$r[12] = $r_get_data[9];	
												}
											}
										}
									}
					
							if ($step==''){$step = "Unknown Step";}
									?>                
                <tr>

                  <td><?php echo e($no_urut) ; ?></td>
                  <td><?php echo e($r[0]) ; ?></td>
                  <td><?php echo e($r[1]) ; ?></td>
                  <td><?php echo e($r[3]) ; ?><br>
                  <?php echo e($r[13]) ; ?> - <?php echo e($r[14]) ; ?></td>
                  </tr>
                <?php $no_urut = num($no_urut) + 1; $step ='';} }?>
                </tbody>
                <tfoot>
                </tfoot>
              </table>
                <table width="1073">
            <tr>
              <td width="190"><strong>Action : </strong></td>
              <td width="173"><strong>Result : </strong></td>
              <td width="190"><strong>Status : </strong></td>
              <td width="427">&nbsp;</td>
              <td width="59">&nbsp;</td>
            </tr>
            <tr>
              <td><label>
              <select name="current_action" >
			<option>Call</option>
				<option>Chat</option>
				<option>Appointment</option>
                <option selected  = "selected">
                <?php if ($current_action != '') {echo e($current_action) ;} else {echo e($action) ;} ?>
                </option>
              </select>
              </label></td>
              <td><select name="result" >
                <option>NIT - Not Interested</option>
                <option>NET - Not Enough Time</option>
                <option>Dis - Distances</option>
                <option>CNR - Could Not Reach</option>
                <option>INT- Interested</option>
				<option selected  = "selected">
                  <?php if ($result != '') {echo e($result) ;} else {echo e($result) ;} ?>
                  </option>
              </select></td>
              <td><select name="current_status" onChange="this.form.submit()">
                <option>N/A</option>			  
                <option>P</option>
                <option>IP</option>
                <option>E</option>
                <option>L</option>
                <option>Fp</option>
                <option>NP</option>
			  <option selected  = "selected"><?php if ($current_status != '') {echo e($current_status) ;} else {echo e($status) ;} ?></option>
              </select>			  </td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Remark : </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><label>
                <input type="text" name="remark" size="150" value="<?php echo e($remark) ?>">
              </label></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong>Preference Destination </strong></td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Choice 1  </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Country </strong></td>
              <td><span style="color: #FFFFFF">
                <select name="flt_country1" id="flt_country1"onChange="this.form.submit()" >
                  <option value= "">
                  <?php echo e($list_country1)?>
                  </option>
                  <option selected="selected">
                  <?php  		   if ($flt_country1 !="") { echo e($flt_country1); }else { if ($country_dest1 !='') {echo e($country_dest1);}else{echo e($country_1);} }

   ?>	
                  </option>
                </select>
                <label for="textfield"></label>
                <input type="text" name="kd_school_1" id="kd_school_1" value="<?php echo e($kd_school_1) ?>" hidden="hidden">
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>School</strong></td>
              <td colspan="4"><span class="style92" style="color: #FFFFFF">
                <select name="flt_school1" id="flt_school1" onChange="this.form.submit()" >
                  <option value= >
                  <?php echo e($list_school1)?>
                  <option selected="selected">
                  <?php  if ($flt_school1 !="") {echo e($flt_school1);}else{if($school_dest1 != ''){echo e($school_dest1);}else{echo e($school_1);}}?>
                  </option>
                </select>
              </span></td>
            </tr>
            <tr>
              <td><strong>Program</strong></td>
              <td><span class="style92" style="color: #FFFFFF">
                <select name="flt_program1" id="flt_program1">
                  <option value= >
                  <?php echo e($list_program)?>
                  <option selected="selected">
                  <?php  if ($flt_program1 !="") { echo e($flt_program1); }else { if ($flt_program1 !=''){echo e($program_dest1); }{echo e($program_1);}}
 				  
   ?>
                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="5">
			  <?php if (($current_status == 'E') ||($status == 'E')) 
			  {
			  if ($status == 'E')
			 	{
				$query_enroll = q_set($__p_query_enroll, "select major_dest, status_host,status_part, date_format(enroll_date,'%d') ,date_format(enroll_date,'%m') ,date_format(enroll_date,'%Y') , date_format(intake_date,'%m') , date_format(intake_date,'%Y') ,status, org_prof_cur,org_prof_fee,prof_fee,  discount_name from ves_inc.tb_enrolled where kd_biodata = ? and sch_dest = ? limit 1", [(string) ($kd_biodata), (string) ($school_dest)]);

				$resource_enroll = db_query_soft($query_enroll, $__p_query_enroll ?? []);
				$keluar_enroll = db_num_rows($resource_enroll);
				if(num(db_num_rows($resource_enroll)) > 0)
					{
					while ($row_enroll  =  db_fetch($resource_enroll, PDO::FETCH_NUM))
						{
						$Major = $row_enroll[0];
						$hadnon = $row_enroll[1];
						$pnp = $row_enroll[2];
						$enroll_dd = $row_enroll[3];
						$enroll_mm = $row_enroll[4];
						$enroll_yy = $row_enroll[5];
						$intake_mmm = $row_enroll[6];
						$intake_yyy = $row_enroll[7];
						$program_status = $row_enroll[8];
						$org_cur = $row_enroll[9];
						$org_pf = $row_enroll[10];
						$pf = $row_enroll[11];
						$discount = $row_enroll[12];
						$pf = $row_enroll[13];
						}
					}
				}

			  ?>
			  <table width="1050" border="0">
                <tr>
                  <td width="174"><strong>Major</strong></td>
                  <td colspan="4"><input type="Major" name="Major" size="50" value="<?php echo e($Major) ?>"></td>
                  </tr>
                <tr>
                  <td><strong>H/AD/Other</strong></td>
                  <td width="189"><span class="style92" style="color: #FFFFFF">
                    <select name="hadnon" id="hadnon">
                      <option>H</option>
                      <option>STEM</option>
                      <option>AD</option>
                      <option>NON</option>
                      <option selected="selected">
                      <?php   echo e($hadnon);    ?>
                      </option>
                    </select>
                  </span></td>
                  <td width="81"><strong>Partnership</strong></td>
                  <td width="86"><span class="style92" style="color: #FFFFFF">
                    <select name="pnp" id="pnp">
                      <option>P</option>
                      <option>NP</option>
                      <option selected="selected">
                      <?php  echo e($pnp) ;   ?>
                      </option>
                    </select>
                  </span></td>
                  <td width="498">&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Enroll Date </strong></td>
                  <td colspan="4"><span class="style2">
                    <select name="enroll_ddd" id="select">
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option>13</option>
                      <option>14</option>
                      <option>15</option>
                      <option>16</option>
                      <option>17</option>
                      <option>18</option>
                      <option>19</option>
                      <option>20</option>
                      <option>21</option>
                      <option>22</option>
                      <option>23</option>
                      <option>24</option>
                      <option>25</option>
                      <option>26</option>
                      <option>27</option>
                      <option>28</option>
                      <option>29</option>
                      <option>30</option>
                      <option>31</option>
                      <option selected="selected"> <?php echo e($enroll_dd);  ?> </option>
                    </select>
                    <select name="enroll_mmm" id="select2">
                      <option>01</option>
                      <option>02</option>
                      <option>03</option>
                      <option>04</option>
                      <option>05</option>
                      <option>06</option>
                      <option>07</option>
                      <option>08</option>
                      <option>09</option>
                      <option>10</option>
                      <option>11</option>
                      <option>12</option>
                      <option selected="selected"> <?php echo e($enroll_mm);  ?> </option>
                    </select>
                    <select name="enroll_yyy" id="select3">
                      <option>2016</option>
                      <option>2017</option>
                      <option>2018</option>
                      <option>2019</option>
                      <option selected="selected"> <?php echo e($enroll_yy)  ?> </option>
                    </select>
                  </span></td>
                  </tr>
                <tr>
                  <td><strong>Intake Date </strong></td>
                  <td colspan="4"><span class="style2">
                      <select name="intake_mmm" id="intake_mmm">
                        <option>01</option>
                        <option>02</option>
                        <option>03</option>
                        <option>04</option>
                        <option>05</option>
                        <option>06</option>
                        <option>07</option>
                        <option>08</option>
                        <option>09</option>
                        <option>10</option>
                        <option>11</option>
                        <option>12</option>
                        <option selected="selected"> <?php if ($intake_mmm != ''){echo e($intake_mmm);} else {echo e($intake_mm);  }?> </option>
                      </select>
                      <select name="intake_yyy" id="intake_yyy">
                        <option>2016</option>
                        <option>2017</option>
                        <option>2018</option>
                        <option selected="selected"><?php if ($intake_yyy != ''){echo e($intake_yyy);} else {echo e($intake_yy);  }?>  </option>
                      </select>
                  </span></td>
                  </tr>
                <tr>
                  <td><strong>Program Status </strong></td>
                  <td><span class="style2">
                    <select name="program_status" id="program_status">
                      <option>Main</option>
                      <option>Language</option>
                      <option>Additional</option>
                      <option selected="selected"> <?php echo e($program_status);  ?> </option>
                    </select>
                  </span></td>
                  <td colspan="2">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td><strong>Admission Handler </strong></td>
                  <td><span class="style90">
                    <select name="dochandler"  style="background-color: #D0DAF0">
                      <option value= "">
                      <?php echo e($list_sc)?>
                      </option>
                      <option selected="selected">
                      <?php  echo e($nm_sc);    ?>
                                        </select>
                  </span></td>
                  <td colspan="2"><strong>Visa Handler Handler </strong></td>
                  <td><span class="style90">
                    <select name="visahandler"  style="background-color: #D0DAF0">
                      <option value= "">
                      <?php echo e($list_sc)?>
                      </option>
                      <option selected="selected">
                      <?php  echo e($nm_sc);    ?>
                                        </select>
                  </span></td>
                </tr>
                <tr>
                  <td><strong>Priority</strong></td>
                  <td colspan="4"><span class="style92" style="color: #FFFFFF">
                    <select name="prioritas" id="prioritas">
                      <option>1</option>
                      <option>2</option>
                      <option>3</option>
                      <option>4</option>
                      <option>5</option>
                      <option>6</option>
					  
                      <option selected="selected">
                      <?php   echo e($prioritas);    ?>
                      </option>
                    </select>
                  </span></td>
                  </tr>
                <tr>
                  <td colspan="5"><strong>Original Proffesional Fee	</strong></td>
                  </tr>
                <tr>
                  <td><strong>Currency</strong></td>
                  <td><span class="style92" style="color: #FFFFFF">
                    <select name="org_cur" id="org_cur">
					<option>USD </option>
					<option>EUR</option>
					<option>GBP</option>
					<option>IDR</option>
					<option>AUD</option>
					<option>CAD </option>
					<option>SGD</option>
					<option>CHF</option>
					<option>MYR</option>
					<option>JPY</option>
					<option>CNY</option>
                      <option selected="selected">
                      <?php   echo e($org_cur);    ?>
                      </option>
                    </select>
                    <input type="org_pf" name="org_pf" size="15" value="<?php echo e($org_pf) ?>">
                  </span></td>
                  <td align="right"><strong>Rp.</strong></td>
                  <td colspan="2"><span class="style92" style="color: #FFFFFF">
                    <input type="pf" name="pf" size="15" value="<?php echo e($pf) ?>">
                  </span></td>
                  </tr>
                
                <tr>
                  <td><strong>Discount</strong></td>
                  <td><span class="style92" style="color: #FFFFFF">
                    <span class="style92" style="color: #FFFFFF">
                    <select name="discount" id="discount" >
                    <option>No Discount</option>
                    <option>Link & Match</option>                    
                    <option selected="selected">
                      <?php  echo e($discount);  ?>
                      </option>
                    </select>
                    </span></span></td>
                  <td  align="right" colspan="2">&nbsp;</td>
                  <td>&nbsp;</td>
                </tr>
                <tr>
                  <td>&nbsp;</td>
                  <td colspan="4">&nbsp;</td>
                </tr>
              </table>
			  <?php } ?> </td>
              </tr>
            <tr>
              <td><strong>Choice 2 </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Country </strong></td>
              <td><span style="color: #FFFFFF">
                <select name="flt_country2" id="flt_country2"onChange="this.form.submit()" >
                  <option value= ""> <?php echo e($list_country2)?> </option>
                  <option selected="selected">
                    <?php  		   if ($flt_country2 !="") { echo e($flt_country2); }else { if ($country_dest2 !='') {echo e($country_dest2);}else{echo e($country_2);} }

   ?>
                    </option>
                </select>
                <input type="text" name="kd_school_2" id="kd_school_2" value="<?php echo e($kd_school_2) ?>" hidden="hidden">
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>School</strong></td>
              <td colspan="4"><span class="style92" style="color: #FFFFFF">
                <select name="flt_school2" id="flt_school2" onChange="this.form.submit()" >
                  <option value= > <?php echo e($list_school2)?>
                    <option selected="selected">
                <?php  if ($flt_school2 !="") {echo e($flt_school2);}else{if($school_dest2 != ''){echo e($school_dest2);}else{echo e($school_2);}}?>
                    </option>
                </select>
              </span></td>
            </tr>
            <tr>
              <td><strong>Program</strong></td>
              <td><span class="style92" style="color: #FFFFFF">
                <select name="flt_program2" id="flt_program2">
                  <option value= > <?php echo e($list_program)?>
                    <option selected="selected">
                      <?php  if ($flt_program2 !="") { echo e($flt_program2); }else { if ($flt_program2 !=''){echo e($program_dest2); }{echo e($program_2);}}
 				  
   ?>
                    </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Choice 3 </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>Country </strong></td>
              <td><span style="color: #FFFFFF">
                <select name="flt_country3" id="flt_country3"onChange="this.form.submit()" >
                  <option value= ""> <?php echo e($list_country3)?> </option>
                  <option selected="selected">
                    <?php  		   if ($flt_country3 !="") { echo e($flt_country3); }else { if ($country_dest3 !='') {echo e($country_dest3);}else{echo e($country_3);} }

   ?>
                    </option>
                </select>
                <input type="text" name="kd_school_3" id="kd_school_3" value="<?php echo e($kd_school_3) ?>"  hidden="hidden">
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><strong>School</strong></td>
              <td colspan="4"><span class="style92" style="color: #FFFFFF">
                <select name="flt_school3" id="flt_school3" onChange="this.form.submit()" >
                  <option value= > <?php echo e($list_school3)?>
                    <option selected="selected">
                <?php  if ($flt_school3 !="") {echo e($flt_school3);}else{if($school_dest3 != ''){echo e($school_dest3);}else{echo e($school_3);}}?>
 
                    </option>
                </select>
              </span></td>
            </tr>
            <tr>
              <td><strong>Program</strong></td>
              <td><span class="style92" style="color: #FFFFFF">
                <select name="flt_program3" id="flt_program3">
                  <option value= > <?php echo e($list_program)?>
                    <option selected="selected">
                      <?php  if ($flt_program3 !="") { echo e($flt_program3); }else { if ($flt_program3 !=''){echo e($program_dest3); }{echo e($program_3);}}
 				  
   ?>
                    </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td width="190"><strong>Next Action : </strong></td>
              <td width="173"><strong>Remark : </strong></td>
              <td width="190">&nbsp;</td>
              <td width="427">&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><label>
                <select name="nextaction">
                  <option>Call</option>
                  <option>Chat</option>
                  <option>Appointment</option>
                  <option selected="selected"><?php echo e($nextaction) ?></option>
                </select>
              </label></td>
              <td colspan="4"><input type="nextremark" name="nextremark" size="120" value="<?php echo e($nextremark) ?>"></td>
            </tr>
            <tr>
              <td width="190"><strong>Due Date  : </strong></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td><span class="style2">
                <select name="due_date_dd" id="due_date_dd">
                  <option>01</option>
                  <option>02</option>
                  <option>03</option>
                  <option>04</option>
                  <option>05</option>
                  <option>06</option>
                  <option>07</option>
                  <option>08</option>
                  <option>09</option>
                  <option>10</option>
                  <option>11</option>
                  <option>12</option>
                  <option>13</option>
                  <option>14</option>
                  <option>15</option>
                  <option>16</option>
                  <option>17</option>
                  <option>18</option>
                  <option>19</option>
                  <option>20</option>
                  <option>21</option>
                  <option>22</option>
                  <option>23</option>
                  <option>24</option>
                  <option>25</option>
                  <option>26</option>
                  <option>27</option>
                  <option>28</option>
                  <option>29</option>
                  <option>30</option>
                  <option>31</option>
                  <option selected="selected">
                  <?php echo e($due_date_dd);  ?>                  </option>
                </select>
                <select name="due_date_mm" id="due_date_mm">
                  <option>01</option>
                  <option>02</option>
                  <option>03</option>
                  <option>04</option>
                  <option>05</option>
                  <option>06</option>
                  <option>07</option>
                  <option>08</option>
                  <option>09</option>
                  <option>10</option>
                  <option>11</option>
                  <option>12</option>
                  <option selected="selected">
                 <?php echo e($due_date_mm);  ?>                  </option>
                </select>
                <select name="due_date_yy" id="due_date_yy">
                   <option>2016</option>
                  <option>2017</option>
                  <option>2018</option>
                  <option>2019</option>
                  <option selected="selected">
                  <?php echo e($due_date_yy)  ?>                  </option>
                </select>
              </span></td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
              <td>&nbsp;</td>
            </tr>
            <tr>
              <td colspan="4"><strong class="huruf"><a href="studentprogres.php?kd_biodata=<?php echo e(u($kode_student))?>"  style="font-weight: bold" target="_parent">
                <input type="submit" name="Submit" value="Submit" />
              </a></strong></td>
              <td>&nbsp;</td>
            </tr>
          </table>
              </div>@charset "utf-8";
/* CSS Document */

