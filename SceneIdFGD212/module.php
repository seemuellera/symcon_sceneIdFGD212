<?php

// Klassendefinition
class SceneIdFGD212 extends IPSModule {
 
	// Der Konstruktor des Moduls
	// Überschreibt den Standard Kontruktor von IPS
	public function __construct($InstanceID) {
		// Diese Zeile nicht löschen
		parent::__construct($InstanceID);

		// Selbsterstellter Code
	}

	// Überschreibt die interne IPS_Create($id) Funktion
	public function Create() {
		
		// Diese Zeile nicht löschen.
		parent::Create();

		// Properties
		$this->RegisterPropertyString("Sender","SceneIdFGD212");
		$this->RegisterPropertyInteger("RefreshInterval",0);
		$this->RegisterPropertyInteger("SceneId",0);
		$this->RegisterPropertyBoolean("DebugOutput",false);
		$this->RegisterPropertyString("SceneActions", "");
		
		// Variables
		$this->RegisterVariableInteger("LastTrigger","Last Trigger","~UnixTimestamp");

		// Default Actions
		// $this->EnableAction("Status");

		// Timer
		$this->RegisterTimer("RefreshInformation", 0 , 'SCENEIDFGD212_RefreshInformation($_IPS[\'TARGET\']);');
    }

	public function Destroy() {

		// Never delete this line
		parent::Destroy();
	}
 
	// Überschreibt die intere IPS_ApplyChanges($id) Funktion
	public function ApplyChanges() {

		$newInterval = $this->ReadPropertyInteger("RefreshInterval") * 1000;
		$this->SetTimerInterval("RefreshInformation", $newInterval);
		
		// Also register the target variable to keep track of change events
		$this->RegisterMessage($this->ReadPropertyInteger("SceneId"), VM_UPDATE);
		
		$this->LogMessage($this->ReadPropertyString("SceneActions"), "DEBUG");
		
		// Diese Zeile nicht löschen
		parent::ApplyChanges();
	}


	public function GetConfigurationForm() {
        	
		// Initialize the form
		$form = Array(
            		"elements" => Array(),
					"actions" => Array()
        		);

		// Add the Elements
		$form['elements'][] = Array("type" => "NumberSpinner", "name" => "RefreshInterval", "caption" => "Refresh Interval");
		$form['elements'][] = Array("type" => "CheckBox", "name" => "DebugOutput", "caption" => "Enable Debug Output");
		$form['elements'][] = Array("type" => "SelectVariable", "name" => "SceneId", "caption" => "Scene ID of source device");
		
		$sceneActionsColumns = Array(
			Array(
				"caption" => "Scene Name",
				"Name" => "SceneName",
				"width" => "650px",
				"edit" => Array("type" => "ValidationTextBox", "enabled" => false)
			),
			Array(
				"caption" => "Scene ID",
				"Name" => "SceneId",
				"width" => "auto",
				"edit" => Array("type" => "NumberSpinner", "enabled" => false)
			),
			Array(
				"caption" => "Active",
				"Name" => "SceneActive",
				"width" => "auto",
				"edit" => Array("type" => "CheckBox")
			),
			Array(
				"caption" => "Variable Id",
				"name" => "VariableId",
				"width" => "auto",
				"edit" => Array("type" => "SelectVariable")
			)
		);
		
		$sceneActionsValues = Array(
			Array(
				"SceneName" => "S1 single click",
				"SceneId" => "16",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S1 double click",
				"SceneId" => "14",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S1 hold",
				"SceneId" => "12",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S1 release",
				"SceneId" => "13",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S2 single click",
				"SceneId" => "26",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S2 double click",
				"SceneId" => "24",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S2 tripple click",
				"SceneId" => "25",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S2 hold",
				"SceneId" => "22",
				"Active" => false,
				"VariableId" => "0"
			),
			Array(
				"SceneName" => "S2 release",
				"SceneId" => "23",
				"Active" => false,
				"VariableId" => "0"
			)
		);
		
		$form['elements'][] = Array(
			"type" => "List", 
			"columns" => $sceneActionsColumns,
			"name" => "SceneActions", 
			"caption" => "Scene Actions", 
			"add" => false, 
			"delete" => false,
			"rowCount" => 9,
			"values" => $sceneActionsValues
		);
		
		// Add the buttons for the test center
		$form['actions'][] = Array(	"type" => "Button", "label" => "Refresh", "onClick" => 'SCENEIDFGD212_RefreshInformation($id);');

		// Return the completed form
		return json_encode($form);

	}
	
	protected function LogMessage($message, $severity = 'INFO') {
		
		if ( ($severity == 'DEBUG') && ($this->ReadPropertyBoolean('DebugOutput') == false )) {
			
			return;
		}
		
		$messageComplete = $severity . " - " . $message;
		
		IPS_LogMessage($this->ReadPropertyString('Sender'), $messageComplete);
	}

	public function RefreshInformation() {

		$this->LogMessage("Refresh in Progress", "DEBUG");
		
	}

	public function RequestAction($Ident, $Value) {
	
	
		switch ($Ident) {
		
			case "Status":
				SetValue($this->GetIDForIdent($Ident), $Value);
				break;
			default:
				throw new Exception("Invalid Ident");
		}
	}
	
	public function MessageSink($TimeStamp, $SenderId, $Message, $Data) {
	
		$this->LogMessage("$TimeStamp - $SenderId - $Message - " . implode(",",$Data) , "DEBUG");
	}

}
