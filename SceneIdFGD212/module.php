<?php

// Klassendefinition
class SceneIdFGD212 extends IPSModule {
 
	// Der Konstruktor des Moduls
	// Überschreibt den Standard Kontruktor von IPS
	public function __construct($InstanceID) {
		// Diese Zeile nicht löschen
		parent::__construct($InstanceID);

		// Selbsterstellter Code
		$this->SceneNames = Array(
			"16" => "S1 single click",
			"14" => "S1 double click",
			"12" => "S1 hold",
			"13" => "S1 release",
			"26" => "S2 single click",
			"24" => "S2 double click",
			"25" => "S2 tripple click",
			"22" => "S2 hold",
			"23" => "S2 release"
		);
	}

	// Überschreibt die interne IPS_Create($id) Funktion
	public function Create() {
		
		// Diese Zeile nicht löschen.
		parent::Create();

		// Properties - Global
		$this->RegisterPropertyString("Sender","SceneIdFGD212");
		$this->RegisterPropertyInteger("RefreshInterval",0);
		$this->RegisterPropertyInteger("SceneId",0);
		$this->RegisterPropertyBoolean("DebugOutput",false);
		// Properties - Scenes
		$this->RegisterPropertyBoolean("SceneS1SingleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1DoubleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1HoldEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1ReleaseEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2SingleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2DoubleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2TrippleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2HoldEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2ReleaseEnabled",false);
		
		// Variables
		$this->RegisterVariableInteger("LastTrigger","Last Trigger","~UnixTimestamp");
		$this->RegisterVariableString("LastAction","Last Action");

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
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[16],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS1SingleClickEnabled",
					"caption" => "Enable Scene"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[14],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS1DoubleClickEnabled",
					"caption" => "Enable Scene"
				)
			)
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
