<?php

/**
 * @property CI_DB_active_record $db
 * @property DX_Auth $dx_auth
 */
class New_level_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    public function getSettings() {
        $settings = $this->db->select('settings')
                ->where('identif', 'new_level')
                ->get('components')
                ->row_array();

        $settings = unserialize($settings['settings']);

        return $settings;
    }
    
     public function setSettings($settings) {
         $settings['thema'] = $this->getthema();
        return $this->db->where('identif', 'new_level')
                        ->update('components', array('settings' => serialize($settings)
        ));
    }

    public function getProperties() {
        return $this->db
                    ->select('shop_product_properties_i18n.id, shop_product_properties_i18n.name, mod_new_level_product_properties_types.type as type')
                    ->join('mod_new_level_product_properties_types','mod_new_level_product_properties_types.property_id=shop_product_properties_i18n.id', 'left')
                    ->get('shop_product_properties_i18n')
                    ->result_array();
    }
    public function setPropertyType($propety_id,$type) {
            $types = $this->db->select('type')
                    ->where('property_id', $propety_id)
                    ->get('mod_new_level_product_properties_types')->row_array();
            if(!$types){
                $types =array();
            }else{
                $types = unserialize($types['type']);
            }
            
            if(!in_array($type, $types)){
                array_push($types, $type);
                 $types = serialize($types);
                 $this->db
                    ->where('property_id', $propety_id)
                    ->update('mod_new_level_product_properties_types', array('type' => $types));
                if(!$this->db->affected_rows()){
                    return  $this->db
                           ->where('property_id', $propety_id)
                           ->insert('mod_new_level_product_properties_types', array('property_id' => $propety_id, 'type' => $types));
                }
            }else{
                return FALSE;
            }    
        
    }
    
    public function getthema(){
        
        $sql = "select settings from components where name = 'new_level'";
        $data = unserialize($this->db->query($sql)->row()->settings);
        return $data['thema'];
    }
     public function removePropertyType($propety_id,$type) {
            $types = $this->db->select('type')
                    ->where('property_id', $propety_id)
                    ->get('mod_new_level_product_properties_types')->row_array();
            
            $types = unserialize($types['type']);
            
            if(in_array($type, $types)){
               unset($types[array_search($type, $types)]);
                 $types = serialize($types);
                 $this->db
                    ->where('property_id', $propety_id)
                    ->update('mod_new_level_product_properties_types', array('type' => $types));
            }else{
                return FALSE;
            }    
    }
    
     public function deletePropertyTypeFromSettings($del_type) {
         $settings = $this->getSettings();
         $newPropertiesTypes = $settings['propertiesTypes'];
         foreach($newPropertiesTypes as $key => $propertyType){
             if($propertyType==$del_type){
                 unset($newPropertiesTypes[$key]);
             }
         }
         
         $properties = $this->db->select('property_id')
                    ->get('mod_new_level_product_properties_types');
         
        if($properties){
            $properties = $properties->result_array();
            
            foreach($properties as $property){
                $this->removePropertyType($property['property_id'], $del_type); 
            }
        }
         
         
         $settings['propertiesTypes'] = $newPropertiesTypes;
         $this->setSettings($settings);
    }
    
    public function editPropertyType($oldType, $newType) {
         $settings = $this->getSettings();
         $newPropertiesTypes = $settings['propertiesTypes'];
         foreach($newPropertiesTypes as $key => $propertyType){
             if($propertyType==$oldType){
                 $newPropertiesTypes[$key] = $newType;
             }
         }
         
         $settings['propertiesTypes'] = $newPropertiesTypes;
         $this->setSettings($settings);
    }
    
    public function addType($newType){
         $settings = $this->getSettings();
         array_push($settings['propertiesTypes'], $newType);
         $this->setSettings($settings);
    }
    public function getPropertyTypes($property_id){
        $result = $this->db
                ->select('type')
                ->where('property_id',$property_id)
                ->get('mod_new_level_product_properties_types')
                ->row_array();        
        if($result){
            return unserialize($result['type']);
        }else{
            return FALSE;
        }
    }
    
     public function getCategories() {
       $locale = MY_Controller::getCurrentLocale();
       $categories = ShopCore::app()->SCategoryTree->getTree();
       return $categories;
    }
    
    
     public function getColumnCategories() {
        $query = $this->db->get('mod_new_level_columns')->result_array();
        $categories =array();
        foreach($query as $value){
            $categories[$value['column']] = unserialize($value['category_id']);
        }
        return $categories;
    }
    
     public function saveCategories($categories_ids, $column){
        $this->db->where('column', $column)->update('mod_new_level_columns', array('category_id' => serialize($categories_ids)));
        if(!$this->db->affected_rows()){
            return $this->db
                            ->insert('mod_new_level_columns', array('category_id' => serialize($categories_ids), 'column' => $column));
        }
    }
    
    public function getColumns(){
        $query = $this->db->get('mod_new_level_columns');
        if($query){
            return $query->result_array();
        }else{
            return 0;
        }
    }
    
    public function deleteColumnFromSettings($del_column) {
         $settings = $this->getSettings();
         $newColumns = $settings['columns'];
         
         foreach($newColumns as $key => $column){
             if($column==$del_column){
                 unset($newColumns[$key]);
             }
         }
         
         $columns = $this->db->where('column',$del_column)
                    ->delete('mod_new_level_columns');
         
         $settings['columns'] = $newColumns;
         $this->setSettings($settings);
    }
    
    public function addColumn($newColumn){
         $settings = $this->getSettings();
         array_push($settings['columns'], $newColumn);
         $this->setSettings($settings);
    }
    
    public function editColumn($oldColumn, $newColumn) {
         $settings = $this->getSettings();
         $newColumns = $settings['columns'];
         
         foreach($newColumns as $key => $column){
             if($column==$oldColumn){
                 $newColumns[$key] = $newColumn;
             }
         }
         
         $this->db->where('column', $oldColumn)->update('mod_new_level_columns', array('column' => $newColumn));
         
         $settings['columns'] = $newColumns;
         $this->setSettings($settings);
    }    
    
}

?>
