<link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/sh-print.css">

<div class="print-area">
  <div class="container">
    <div class="row">
      <div class="col-12">
        <?php if (!empty($print_details[0]['print_header'])) { ?>
          <div class="pprinta4">
            <img src="<?php
            if (!empty($print_details[0]['print_header'])) {
                echo base_url() . $print_details[0]['print_header'].img_time();
            }
            ?>" class="img-responsive" style="height:100px; width: 100%;">
          </div>
        <?php } ?>
      <div class="card">
        <div class="card-body">  
          <div class="row">
            <div class="col-md-6">          
              <p><span class="font-bold"><?php echo $this->lang->line('bill_no'); ?> :</span> <?php echo$this->customlib->getPatientSessionPrefixByType('pathology_billing') .$result->pathology_bill_id; ?></p>
              <p><span class="font-bold"><?php echo $this->lang->line('case_id'); ?> :</span> <?php echo  $result->case_reference_id; ?></p>
              <p><span class="font-bold"><?php echo $this->lang->line('patient'); ?> :</span> <?php echo composePatientName($result->patient_name,$result->patient_id); ?></p>
              <p><span class="font-bold"><?php echo $this->lang->line('age'); ?> :</span> <?php echo $this->customlib->getPatientAge($result->age,$result->month,$result->day); ?></p>
              <p><span class="font-bold"><?php echo $this->lang->line('gender'); ?> :</span> <?php echo $result->gender; ?></p>
              <p><span class="font-bold"><?php echo $this->lang->line('collection_by'); ?> :</span> <?php echo composeStaffNameByString($result->collection_specialist_staff_name,$result->collection_specialist_staff_surname,$result->collection_specialist_staff_employee_id); ?></p>
              <p><span class="font-bold"><?php echo $this->lang->line('pathology_center'); ?> :</span> <?php echo $result->pathology_center ?></p>
            </div>
            <div class="col-md-6 text-right">                     
             <p><span class="text-muted font-bold"><?php echo $this->lang->line('approve_date'); ?>: </span> <?php echo $this->customlib->YYYYMMDDTodateFormat($result->parameter_update); ?></p>   
              <p><span class="text-muted font-bold"><?php echo $this->lang->line('report_collection_date'); ?>: </span> <?php echo $this->customlib->YYYYMMDDTodateFormat($result->collection_date); ?></p>
              <p><span class="text-muted font-bold"><?php echo $this->lang->line('expected_date'); ?>: </span> <?php echo $this->customlib->YYYYMMDDTodateFormat($result->reporting_date); ?></p> 
            </div>
          </div>
          <div class="row">
            <div class="col-md-12">
              <h4 class="text-center">
                <?php echo $result->test_name; ?>
                <br/>
                 <?php echo "(".$result->short_name.")"; ?>
              </h4>
              <table class="print-table">
                <thead>
                  <tr class="line">
                    <th>S.No</th>
                    <th class="text-left"><?php echo $this->lang->line('test_parameter_name'); ?></th>
                    <th class="text-center"><?php echo $this->lang->line('reference_range'); ?></th>
                    <th class="text-right"><?php echo $this->lang->line('report_value'); ?></th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $row_counter=1;
                  foreach ($result->pathology_parameter as $parameter_key=> $parameter_value) {
                  ?>                        
                  <tr>
                    <td><?php echo $row_counter; ?></td>
                    <td class="text-left">
                      <?php echo $parameter_value->parameter_name; ?> <div class="bill_item_footer text-muted"><label><?php if($parameter_value->description !=''){ echo $this->lang->line('description').': ';} ?></label> <?php echo $parameter_value->description; ?></div>   
                    </td> 
                    <td class="text-center">
                      <?php echo $parameter_value->reference_range." ".$parameter_value->unit_name; ?>                               
                    </td>
                    <td class="text-right">    
                    <?php if($parameter_value->pathology_report_value!="" ) { echo $parameter_value->pathology_report_value." ".$parameter_value->unit_name; } ?>
                    </td>                             
                  </tr>        
                 <?php 
                    $row_counter++;
                        }

                      if($parameter_value->pathology_result!=""){ ?> 
                        <tr> <td colspan="4"><p><b><?php echo $this->lang->line('result'); ?>: </b> <?php echo nl2br($parameter_value->pathology_result); ?></p></td></tr>                             
                        <?php
                        }  
                        ?>           
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
        <div style="clear:both"></div>
        <p>
        <?php
        if (!empty($print_details[0]['print_footer'])) {
            echo $print_details[0]['print_footer'];
        }
        ?>                          
        </p>
      </div>
    </div>
  </div>
</div>