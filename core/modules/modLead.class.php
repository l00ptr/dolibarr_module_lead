<?php
/* 
 * Copyright (C) 2014 Florian HENRY <florian.henry@open-concept.pro>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

/**
 * \defgroup	lead	Lead module
 * \brief		Lead module descriptor.
 * \file		core/modules/modLead.class.php
 * \ingroup	lead
 * \brief		Description and activation file for module Lead
 */
include_once DOL_DOCUMENT_ROOT . "/core/modules/DolibarrModules.class.php";

/**
 * Description and activation class for module Lead
 */
class modLead extends DolibarrModules
{

	/**
	 * Constructor.
	 * Define names, constants, directories, boxes, permissions
	 *
	 * @param DoliDB $db        	
	 */
	public function __construct($db)
	{
		global $langs, $conf;
		
		$this->db = $db;
		
		// Id for module (must be unique).
		// Use a free id here
		// (See in Home -> System information -> Dolibarr for list of used modules id).
		$this->numero = 103111;
		// Key text used to identify module (for permissions, menus, etc...)
		$this->rights_class = 'lead';
		
		// Family can be 'crm','financial','hr','projects','products','ecm','technic','other'
		// It is used to group modules in module setup page
		$this->family = "crm";
		// Module label (no space allowed)
		// used if translation string 'ModuleXXXName' not found
		// (where XXX is value of numeric property 'numero' of module)
		$this->name = preg_replace('/^mod/i', '', get_class($this));
		// Module description
		// used if translation string 'ModuleXXXDesc' not found
		// (where XXX is value of numeric property 'numero' of module)
		$this->description = "Description of module Lead";
		// Possible values for version are: 'development', 'experimental' or version
		$this->version = '1.0';
		// Key used in llx_const table to save module status enabled/disabled
		// (where MYMODULE is value of property name of module in uppercase)
		$this->const_name = 'MAIN_MODULE_' . strtoupper($this->name);
		// Where to store the module in setup page
		// (0=common,1=interface,2=others,3=very specific)
		$this->special = 0;
		// Name of image file used for this module.
		// If file is in theme/yourtheme/img directory under name object_pictovalue.png
		// use this->picto='pictovalue'
		// If file is in module/img directory under name object_pictovalue.png
		// use this->picto='pictovalue@module'
		$this->picto = 'lead@lead'; // mypicto@lead
		                            // Defined all module parts (triggers, login, substitutions, menus, css, etc...)
		                            // for default path (eg: /lead/core/xxxxx) (0=disable, 1=enable)
		                            // for specific path of parts (eg: /lead/core/modules/barcode)
		                            // for specific css file (eg: /lead/css/lead.css.php)
		$this->module_parts = array(
			// Set this to 1 if module has its own trigger directory
			// 'triggers' => 1,
			// Set this to 1 if module has its own login method directory
			// 'login' => 0,
			// Set this to 1 if module has its own substitution function file
			// 'substitutions' => 0,
			// Set this to 1 if module has its own menus handler directory
			// 'menus' => 0,
			// Set this to 1 if module has its own barcode directory
			// 'barcode' => 0,
			// Set this to 1 if module has its own models directory
			'models' => 1
		// Set this to relative path of css if module has its own css file
		// 'css' => '/lead/css/mycss.css.php',
		// Set here all hooks context managed by module
		// 'hooks' => array('hookcontext1','hookcontext2')
		// Set here all workflow context managed by module
		// 'workflow' => array('order' => array('WORKFLOW_ORDER_AUTOCREATE_INVOICE'))
				);
		
		// Data directories to create when module is enabled.
		// Example: this->dirs = array("/lead/temp");
		$this->dirs = array(
			'/lead'
		);
		
		// Config pages. Put here list of php pages
		// stored into lead/admin directory, used to setup module.
		$this->config_page_url = array(
			"admin_lead.php@lead"
		);
		
		// Dependencies
		// List of modules id that must be enabled if this module is enabled
		$this->depends = array();
		// List of modules id to disable if this one is disabled
		$this->requiredby = array();
		// Minimum version of PHP required by module
		$this->phpmin = array(
			5,
			3
		);
		// Minimum version of Dolibarr required by module
		$this->need_dolibarr_version = array(
			3,
			4
		);
		$this->langfiles = array(
			"lead@lead"
		); // langfiles@lead
		                                       // Constants
		                                       // List of particular constants to add when module is enabled
		                                       // (key, 'chaine', value, desc, visible, 'current' or 'allentities', deleteonunactive)
		                                       // Example:
		$this->const = array(
			0 => array(
				'LEAD_ADDON',
				'chaine',
				'mod_lead_simple',
				'Numbering lead rule',
				0,
				'allentities',
				1
			),
			1 => array(
				'LEAD_UNIVERSAL_MASK',
				'chaine',
				'',
				'Numbering lead rule',
				0,
				'allentities',
				1
			),
			2 => array(
				'LEAD_NB_DAY_COSURE_AUTO',
				'chaine',
				'30',
				'Numbering lead rule',
				0,
				'allentities',
				1
			),
			3 => array(
				'LEAD_GRP_USER_AFFECT',
				'chaine',
				'',
				'User Group that can affected',
				0,
				'allentities',
				1
			)
		);
		
		// Array to add new pages in new tabs
		// Example:
		$this->tabs = array(
			'thirdparty:+tabLead:Module103111Name:lead@lead:$user->rights->lead->read:/lead/lead/list.php?socid=__ID__'
		// // To add a new tab identified by code tabname1
		// 'objecttype:+tabname1:Title1:langfile@lead:$user->rights->lead->read:/lead/mynewtab1.php?id=__ID__',
		// // To add another new tab identified by code tabname2
		// 'objecttype:+tabname2:Title2:langfile@lead:$user->rights->othermodule->read:/lead/mynewtab2.php?id=__ID__',
		// // To remove an existing tab identified by code tabname
		// 'objecttype:-tabname'
				);
		// where objecttype can be
		// 'thirdparty' to add a tab in third party view
		// 'intervention' to add a tab in intervention view
		// 'order_supplier' to add a tab in supplier order view
		// 'invoice_supplier' to add a tab in supplier invoice view
		// 'invoice' to add a tab in customer invoice view
		// 'order' to add a tab in customer order view
		// 'product' to add a tab in product view
		// 'stock' to add a tab in stock view
		// 'propal' to add a tab in propal view
		// 'member' to add a tab in fundation member view
		// 'contract' to add a tab in contract view
		// 'user' to add a tab in user view
		// 'group' to add a tab in group view
		// 'contact' to add a tab in contact view
		// 'categories_x' to add a tab in category view
		// (replace 'x' by type of category (0=product, 1=supplier, 2=customer, 3=member)
		// Dictionnaries
		if (! isset($conf->lead->enabled)) {
			$conf->lead = (object) array();
			$conf->lead->enabled = 0;
		}
		
		$this->dictionnaries = array(
			'langs' => 'lead@lead',
			'tabname' => array(
				MAIN_DB_PREFIX . "c_lead_status",
				MAIN_DB_PREFIX . "c_lead_type"
			),
			'tablib' => array(
				"LeadStatus",
				"LeadType"
			),
			'tabsql' => array(
				'SELECT f.rowid as rowid, f.code, f.label, f.active FROM ' . MAIN_DB_PREFIX . 'c_lead_status as f',
				'SELECT f.rowid as rowid, f.code, f.label, f.active FROM ' . MAIN_DB_PREFIX . 'c_lead_type as f'
			),
			'tabsqlsort' => array(
				'code ASC',
				'code ASC'
			),
			'tabfield' => array(
				"code,label",
				"code,label"
			),
			'tabfieldvalue' => array(
				"code,label",
				"code,label"
			),
			'tabfieldinsert' => array(
				"code,label",
				"code,label"
			),
			'tabrowid' => array(
				"rowid",
				"rowid"
			),
			'tabcond' => array(
				'$conf->lead->enabled',
				'$conf->lead->enabled'
			)
		);
		
		// Boxes
		// Add here list of php file(s) stored in core/boxes that contains class to show a box.
		$this->boxes = array(); // Boxes list
		$r = 0;
		// Example:
		
		$this->boxes[$r][1] = "box_lead@lead";
		// $r ++;
		/*
		 * $this->boxes[$r][1] = "myboxb.php"; $r++;
		 */
		
		// Permissions
		$this->rights = array(); // Permission array used by this module
		$r = 0;
		$this->rights[$r][0] = 1031111;
		$this->rights[$r][1] = 'See Leads';
		$this->rights[$r][3] = 1;
		$this->rights[$r][4] = 'read';
		$r ++;
		
		$this->rights[$r][0] = 1031112;
		$this->rights[$r][1] = 'Update Leads';
		$this->rights[$r][3] = 1;
		$this->rights[$r][4] = 'write';
		$r ++;
		
		$this->rights[$r][0] = 1031113;
		$this->rights[$r][1] = 'Delete Leads';
		$this->rights[$r][3] = 1;
		$this->rights[$r][4] = 'delete';
		$r ++;
		
		// $r++;
		// Main menu entries
		$this->menus = array(); // List of menus to add
		$r = 0;
		
		$this->menu[$r] = array(
			'fk_menu' => 0,
			'type' => 'top',
			'titre' => 'Module103111Name',
			'mainmenu' => 'lead',
			'leftmenu' => '0',
			'url' => '/lead/lead/list.php',
			'langs' => 'lead@lead',
			'position' => 100,
			'enabled' => '$user->rights->lead->read',
			'perms' => '$user->rights->lead->read',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		$this->menu[$r] = array(
			'fk_menu' => 'fk_mainmenu=lead',
			'type' => 'left',
			'titre' => 'Module103111Name',
			'leftmenu' => 'Module103111Name',
			'url' => '/lead/lead/list.php',
			'langs' => 'lead@lead',
			'position' => 101,
			'enabled' => '$user->rights->lead->read',
			'perms' => '$user->rights->lead->read',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		$this->menu[$r] = array(
			'fk_menu' => 'fk_mainmenu=lead,fk_leftmenu=Module103111Name',
			'type' => 'left',
			'titre' => 'LeadCreate',
			'url' => '/lead/lead/card.php?action=create',
			'langs' => 'lead@lead',
			'position' => 102,
			'enabled' => '$user->rights->lead->write',
			'perms' => '$user->rights->lead->write',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		$this->menu[$r] = array(
			'fk_menu' => 'fk_mainmenu=lead,fk_leftmenu=Module103111Name',
			'type' => 'left',
			'titre' => 'LeadList',
			'url' => '/lead/lead/list.php',
			'langs' => 'lead@lead',
			'position' => 102,
			'enabled' => '$user->rights->lead->read',
			'perms' => '$user->rights->lead->read',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		$this->menu[$r] = array(
			'fk_menu' => 'fk_mainmenu=lead,fk_leftmenu=Module103111Name',
			'type' => 'left',
			'titre' => 'LeadListCurrent',
			'url' => '/lead/lead/list.php?viewtype=current',
			'langs' => 'lead@lead',
			'position' => 103,
			'enabled' => '$user->rights->lead->read',
			'perms' => '$user->rights->lead->read',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		$this->menu[$r] = array(
			'fk_menu' => 'fk_mainmenu=lead,fk_leftmenu=Module103111Name',
			'type' => 'left',
			'titre' => 'LeadListMyLead',
			'url' => '/lead/lead/list.php?viewtype=my',
			'langs' => 'lead@lead',
			'position' => 103,
			'enabled' => '$user->rights->lead->read',
			'perms' => '$user->rights->lead->read',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		$this->menu[$r] = array(
			'fk_menu' => 'fk_mainmenu=lead,fk_leftmenu=Module103111Name',
			'type' => 'left',
			'titre' => 'LeadListLate',
			'url' => '/lead/lead/list.php?viewtype=late',
			'langs' => 'lead@lead',
			'position' => 103,
			'enabled' => '$user->rights->lead->read',
			'perms' => '$user->rights->lead->read',
			'target' => '',
			'user' => 0
		);
		$r ++;
		
		// Exports
		// $r = 1;
		
		// Example:
		// $this->export_code[$r]=$this->rights_class.'_'.$r;
		// // Translation key (used only if key ExportDataset_xxx_z not found)
		// $this->export_label[$r]='CustomersInvoicesAndInvoiceLines';
		// // Condition to show export in list (ie: '$user->id==3').
		// // Set to 1 to always show when module is enabled.
		// $this->export_enabled[$r]='1';
		// $this->export_permission[$r]=array(array("facture","facture","export"));
		// $this->export_fields_array[$r]=array(
		// 's.rowid'=>"IdCompany",
		// 's.nom'=>'CompanyName',
		// 's.address'=>'Address',
		// 's.cp'=>'Zip',
		// 's.ville'=>'Town',
		// 's.fk_pays'=>'Country',
		// 's.tel'=>'Phone',
		// 's.siren'=>'ProfId1',
		// 's.siret'=>'ProfId2',
		// 's.ape'=>'ProfId3',
		// 's.idprof4'=>'ProfId4',
		// 's.code_compta'=>'CustomerAccountancyCode',
		// 's.code_compta_fournisseur'=>'SupplierAccountancyCode',
		// 'f.rowid'=>"InvoiceId",
		// 'f.facnumber'=>"InvoiceRef",
		// 'f.datec'=>"InvoiceDateCreation",
		// 'f.datef'=>"DateInvoice",
		// 'f.total'=>"TotalHT",
		// 'f.total_ttc'=>"TotalTTC",
		// 'f.tva'=>"TotalVAT",
		// 'f.paye'=>"InvoicePaid",
		// 'f.fk_statut'=>'InvoiceStatus',
		// 'f.note'=>"InvoiceNote",
		// 'fd.rowid'=>'LineId',
		// 'fd.description'=>"LineDescription",
		// 'fd.price'=>"LineUnitPrice",
		// 'fd.tva_tx'=>"LineVATRate",
		// 'fd.qty'=>"LineQty",
		// 'fd.total_ht'=>"LineTotalHT",
		// 'fd.total_tva'=>"LineTotalTVA",
		// 'fd.total_ttc'=>"LineTotalTTC",
		// 'fd.date_start'=>"DateStart",
		// 'fd.date_end'=>"DateEnd",
		// 'fd.fk_product'=>'ProductId',
		// 'p.ref'=>'ProductRef'
		// );
		// $this->export_entities_array[$r]=array('s.rowid'=>"company",
		// 's.nom'=>'company',
		// 's.address'=>'company',
		// 's.cp'=>'company',
		// 's.ville'=>'company',
		// 's.fk_pays'=>'company',
		// 's.tel'=>'company',
		// 's.siren'=>'company',
		// 's.siret'=>'company',
		// 's.ape'=>'company',
		// 's.idprof4'=>'company',
		// 's.code_compta'=>'company',
		// 's.code_compta_fournisseur'=>'company',
		// 'f.rowid'=>"invoice",
		// 'f.facnumber'=>"invoice",
		// 'f.datec'=>"invoice",
		// 'f.datef'=>"invoice",
		// 'f.total'=>"invoice",
		// 'f.total_ttc'=>"invoice",
		// 'f.tva'=>"invoice",
		// 'f.paye'=>"invoice",
		// 'f.fk_statut'=>'invoice',
		// 'f.note'=>"invoice",
		// 'fd.rowid'=>'invoice_line',
		// 'fd.description'=>"invoice_line",
		// 'fd.price'=>"invoice_line",
		// 'fd.total_ht'=>"invoice_line",
		// 'fd.total_tva'=>"invoice_line",
		// 'fd.total_ttc'=>"invoice_line",
		// 'fd.tva_tx'=>"invoice_line",
		// 'fd.qty'=>"invoice_line",
		// 'fd.date_start'=>"invoice_line",
		// 'fd.date_end'=>"invoice_line",
		// 'fd.fk_product'=>'product',
		// 'p.ref'=>'product'
		// );
		// $this->export_sql_start[$r] = 'SELECT DISTINCT ';
		// $this->export_sql_end[$r] = ' FROM (' . MAIN_DB_PREFIX . 'facture as f, '
		// . MAIN_DB_PREFIX . 'facturedet as fd, ' . MAIN_DB_PREFIX . 'societe as s)';
		// $this->export_sql_end[$r] .= ' LEFT JOIN ' . MAIN_DB_PREFIX
		// . 'product as p on (fd.fk_product = p.rowid)';
		// $this->export_sql_end[$r] .= ' WHERE f.fk_soc = s.rowid '
		// . 'AND f.rowid = fd.fk_facture';
		// $r++;
	}

	/**
	 * Function called when module is enabled.
	 * The init function add constants, boxes, permissions and menus
	 * (defined in constructor) into Dolibarr database.
	 * It also creates data directories
	 *
	 * @param string $options
	 *        	enabling module ('', 'noboxes')
	 * @return int if OK, 0 if KO
	 */
	public function init($options = '')
	{
		$sql = array();
		
		$result = $this->loadTables();
		
		return $this->_init($sql, $options);
	}

	/**
	 * Function called when module is disabled.
	 * Remove from database constants, boxes and permissions from Dolibarr database.
	 * Data directories are not deleted
	 *
	 * @param string $options
	 *        	enabling module ('', 'noboxes')
	 * @return int if OK, 0 if KO
	 */
	public function remove($options = '')
	{
		$sql = array();
		
		return $this->_remove($sql, $options);
	}

	/**
	 * Create tables, keys and data required by module
	 * Files llx_table1.sql, llx_table1.key.sql llx_data.sql with create table, create keys
	 * and create data commands must be stored in directory /lead/sql/
	 * This function is called by this->init
	 *
	 * @return int if KO, >0 if OK
	 */
	private function loadTables()
	{
		return $this->_load_tables('/lead/sql/');
	}
}
