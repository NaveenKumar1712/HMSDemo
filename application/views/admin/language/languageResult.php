<?php
                                    $count = 1;
                                    foreach ($languagelist as $language) {
                                        ?>
                                        <tr> 
                                            <td><?php echo $count . "."; ?></td>
                                            <td class="mailbox-name"> <?php echo $language['language'] ?> <span class="flag-icon flag-icon-<?php echo $language['country_code']; ?>"></span></td>
                                            <td><?php echo $language['short_code'];?></td>
                                            <td><?php echo $language['country_code'];?></td>
                                            <td class="mailbox-name" id="active<?php echo $language["id"];?>"><?php
                                           $lang= $this->db->select('lang_id')->from('sch_settings')->get()->row_array();
                                                if ($lang['lang_id'] == $language['id']) {
                                                    ?>
                                                    <span class="label bg-green"><?php echo $this->lang->line('active'); ?></span>
                                                    <?php
                                                } else {
                                                    
                                                }
                                                ?></td>

                                                    <td>
                                                        <?php
                                                        // Ensure $selected_lang is an array before using in_array()
                                                        if (!empty($selected_lang) && is_array($selected_lang)) {
                                                            if (in_array($language["id"], $selected_lang)) {
                                                        ?>
                                                                <input type="radio" value="<?php echo $language["id"]; ?>" name="defoult" onclick="defoult(this.value)" <?php if ($lang['lang_id'] == $language['id']) { echo "checked"; } ?>>
                                                        <?php
                                                            }
                                                        }
                                                        ?>
                                                    </td>

                                                <td>
                                                   <input type="checkbox" id="rtl_<?php echo $language["id"]; ?>" value="<?php echo $language["id"]; ?>" name="defoult" onchange="rtl(this.value)"  <?php if($language['is_rtl'] == 'yes'){ echo "checked";} ?>>
                                                </td>
                                            <td class="mailbox-date">
                                               <?php  if($language['is_deleted']=='yes' && $this->customlib->getSessionLanguage() != $language['id'] && ($this->rbac->hasPrivilege('languages', 'can_delete'))){ ?>
<a data-placement="right" onclick="return confirm('<?php echo $this->lang->line('delete_confirm')?>');" href="<?php echo base_url();?>admin/language/delete/<?php echo $language['id']; ?>" class="btn btn-default btn-xs" data-toggle="tooltip" title=""  data-original-title="<?php  echo $this->lang->line('delete')?>">
                                                                        <i class="fa fa-remove"></i>
                                                                    </a>
    <?php  
}
                                                   if($this->customlib->getSessionLanguage() != $language['id']){
                                                if(!empty($selected_lang) ){ ?>
                                              <div class="material-switch pull-right">
                                                    <input id="student<?php echo $language["id"] ?>" name="someSwitchOption001" type="checkbox"
                                                        <?php
                                                        // Ensure $selected_lang is an array before using in_array()
                                                        if (is_array($selected_lang) && in_array($language["id"], $selected_lang)) {
                                                            echo "data-role='1'";
                                                        } else {
                                                            echo "data-role='2'";
                                                        }
                                                        ?>
                                                        class="chk" data-rowid="<?php echo $language["id"] ?>" value="checked" 
                                                        <?php if (is_array($selected_lang) && in_array($language["id"], $selected_lang)) echo "checked='checked'"; ?> />
                                                    <label for="student<?php echo $language["id"] ?>" class="label-success"></label>
                                                </div>

                                                    <?php } } ?>
                                            </td>
                                         
                                        </tr>
                                        <?php
                                        $count++;
                                    }
                                    ?>