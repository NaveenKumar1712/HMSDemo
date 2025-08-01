<?php 
$currency_symbol = $this->customlib->getHospitalCurrencyFormat();
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>backend/dist/css/sh-print.css">
<div class="print-area">
<div class="row">  
        <div class="col-12">
               <?php if (!empty($print_details[0]['print_header'])) { ?>
                        <div class="pprinta4">
                        <?php
                        $logo_image = base_url() . "uploads/staff_images/no_image.png";
                        if (!empty($print_details[0]['print_header'])) {
                            $userdata = $this->session->userdata('hospitaladmin');
                            $accessToken = $userdata['accessToken'] ?? '';

                            $url = "https://phr-api.plenome.com/file_upload/getDocs";
                            $payload = json_encode(['value' => $print_details[0]['print_header']]);
                            $client = curl_init($url);
                            curl_setopt_array($client, [
                                CURLOPT_RETURNTRANSFER => true,
                                CURLOPT_POST => true,
                                CURLOPT_POSTFIELDS => $payload,
                                CURLOPT_HTTPHEADER => ['Content-Type: application/json', 'Authorization: ' . $accessToken],
                            ]);
                            $response = curl_exec($client);
                            curl_close($client);
                            if ($response && strpos($response, '"NoSuchKey"') === false) {
                                $logo_image = "data:image/png;base64," . trim($response);
                            } elseif (!empty($print_details[0]['print_header'])) {
                                $logo_image = base_url() . $print_details[0]['print_header'];
                            }
                        }
                        ?>
                        <img src="<?= $logo_image ?>" class="img-responsive" style="height:100px; width: 100%;">
                        </div>
                    <?php } ?>
           <div class="card mt-1">
                <div class="card-body"> 
                    <div class="row">
                        <?php 
                            $currency_symbol = $this->customlib->getHospitalCurrencyFormat();
                        ?> 
                <div class="box-body pb0">                   
                    <div class="col-md-12 col-lg-10 col-sm-9">                 

                            <table class="print-table" style="text-align: left; padding-top: 10px;">
                                <tbody>
                                    <tr>
                                        <th ><?php echo $this->lang->line('case_id'); ?></th>
                                        <td ><?php echo $case_id;?></td>                                       
                                        <th ><?php echo $this->lang->line('appointment_date'); ?></th>
                                        <td ><?php if($result['appointment_date']!='' && $result['appointment_date']!='0000-00-00'){
                                            echo $this->customlib->YYYYMMDDHisTodateFormat($result['appointment_date']);
                                        } ?>
                                        </td>
                                    </tr> 
                                    <tr>
                                        <th ><?php echo $this->lang->line('name'); ?></th>
                                        <td><?php echo composePatientName($result['patient_name'],$result['patient_id']); ?></td>                                       
                                        <th ><?php echo $this->lang->line('guardian_name'); ?></th>
                                        <td ><?php echo $result['guardian_name']; ?></td>
                                    </tr>
                                    <tr>
                                        <th ><?php echo $this->lang->line('gender'); ?></th>
                                        <td ><?php echo $result['gender']; ?></td>                                
                                        <th ><?php echo $this->lang->line('age'); ?></th>
                                        <td >
                                            <?php
                                             if (!empty($result['dob'])) {
                                                echo $this->customlib->getAgeBydob($result['dob']);
                                             } 
                                            ?>   
                                        </td>
                                    </tr>
                                    <tr>
                                        <th><?php echo $this->lang->line('phone'); ?></th>
                                        <td ><?php echo $result['mobileno']; ?></td>
                                        <?php 
                                    if($result['opdid']!='' && $result['opdid']!=0){ ?>                
                                        <th ><?php echo $this->lang->line('opd_no'); ?></th>
                                        <td ><?php
                                            if($result['opdid']!='' && $result['opdid']!=0){
                                                echo $this->customlib->getSessionPrefixByType('opd_no').$result['opdid'];
                                            }                                   
                                            ?>
                                        </td>                                   
                                    <?php }  
                                    if($result['ipdid']!='' && $result['ipdid']!=0){?>                     
                                        <th ><?php echo $this->lang->line('ipd_no'); ?></th>
                                        <td ><?php
                                            if($result['ipdid']!='' && $result['ipdid']!=0){
                                                echo $this->customlib->getSessionPrefixByType('ipd_no').$result['ipdid'];
                                            }                                            
                                            ?>
                                        </td>                                   
                                    <?php } ?>                                   
                                </tr>
                                <tr>                            
                                    <th ><?php echo $this->lang->line('admission_date');?></th>
                                    <td ><?php if($result['date']!='' && $result['date']!='0000-00-00'){
                                        echo $this->customlib->YYYYMMDDHisTodateFormat($result['date']);
                                    } ?></td>

                                    <th ><?php echo $this->lang->line('discharge_date'); ?></th>
                                    <td >
                                        <?php if((!empty($discharge_card)) && $discharge_card['discharge_date']!=''){ echo $this->customlib->YYYYMMDDHisTodateFormat($discharge_card['discharge_date']); }   ?>
                                    </td>
                                </tr>
                                <tr>                    
                                    <th ><?php echo $this->lang->line('discharge_status'); ?></th>
                                    <td ><?php  echo $this->customlib->discharge_status($discharge_card['discharge_status']);  ?></td> 
                                    <th></th>
                                    <td></td>
                                </tr> 
                                    <?php 
                                         if($discharge_card['discharge_status']==1){
                                    ?>
                                    <tr>                                    
                                        <th ><?php echo $this->lang->line('death_date'); ?></th>
                                        <td >
                                            <?php if((!empty($discharge_card)) && $discharge_card['death_date']!=''){ echo $this->customlib->YYYYMMDDHisTodateFormat($discharge_card['death_date']); }   ?>
                                        </td>                           
                                        <th ><?php echo $this->lang->line('death_report'); ?></th>
                                        <td >
                                            <?php if(!empty($deathrecord)){ echo $deathrecord['death_report'];  } ?>
                                        </td>                                       
                                    </tr> 
                                    <?php
                                         }                                       
                                         if($discharge_card['discharge_status']==2){
                                    ?>
                                    <tr>                                   
                                        <th><?php echo $this->lang->line('referral_date'); ?></th>
                                        <td >
                                        	<?php if((!empty($discharge_card)) && $discharge_card['refer_date']!=''){ echo $this->customlib->YYYYMMDDHisTodateFormat($discharge_card['refer_date']); }   ?>
                                        </td>                             
                                        <th ><?php echo $this->lang->line('referral_hospital_name'); ?></th>
                                        <td >
                                        	<?php if((!empty($discharge_card)) && $discharge_card['refer_to_hospital']!=''){ echo $discharge_card['refer_to_hospital']; }   ?>
                                        </td>                                       
                                    </tr>
                                    <tr>                                   
                                        <th ><?php echo $this->lang->line('reason_for_referral'); ?></th>
                                        <td >
                                        	<?php if((!empty($discharge_card)) && $discharge_card['reason_for_referral']!=''){ echo $discharge_card['reason_for_referral']; }   ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                                <?php 
                                    if(!empty($discharge_card['field_data'])){
                                        foreach ($discharge_card['field_data'] as $key => $value) {
                                    	?>
                                        <tr> <th><?php echo $value['name']; ?></th><td><?php echo $value['field_value']; ?></td></tr>
                                    	<?php
                                        }
                                    }
                                ?>                  
          
                                </tbody>
                            </table>                  
                            <table class="print-table" style="text-align: left; padding-top: 10px;">
                                <tbody>                                
                                    <tr>
                                        <td><b><?php echo $this->lang->line('operation'); ?></b><br><?php if(!empty($discharge_card)){ echo $discharge_card['operation'];  } ?></td>  
                                    </tr>
                                    <tr>
                                        <td><b><?php echo $this->lang->line('diagnosis'); ?></b><br><?php if(!empty($discharge_card)){ echo $discharge_card['diagnosis'];  } ?></td>     
                                    </tr>
                                    <tr>
                                        <td><b><?php echo $this->lang->line('investigation'); ?></b><br><?php if(!empty($discharge_card)){ echo $discharge_card['investigations'];  } ?></td>                                        
                                    </tr>
                                    <tr>
                                        <td><b><?php echo $this->lang->line('treatment_at_home'); ?></b><br><?php if(!empty($discharge_card)){ echo $discharge_card['treatment_home'];  } ?></td>
                                    </tr>
                                <tbody>
                            </table>                  
                        </div>           
                        </div>
                    </div>                   
                </div>
            </div>
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