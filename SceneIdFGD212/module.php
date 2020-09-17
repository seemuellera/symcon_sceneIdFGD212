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
		
		$this->SceneActions = Array(
			Array(
				"caption" => "Toggle Status",
				"value" => "Toggle"
			),
			Array(
				"caption" => "Switch On",
				"value" => "SwitchOn"
			),
			Array(
				"caption" => "Switch Off",
				"value" => "SwitchOff"
			),
			Array(
				"caption" => "Dim to a specifc value",
				"value" => "DimToValue"
			)
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
		
		$this->RegisterPropertyString("SceneS1SingleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS1DoubleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS1HoldAction","Toggle");
		$this->RegisterPropertyString("SceneS1ReleaseAction","Toggle");
		$this->RegisterPropertyString("SceneS2SingleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS2DoubleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS2TrippleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS2HoldAction","Toggle");
		$this->RegisterPropertyString("SceneS2ReleaseAction","Toggle");
		
		$this->RegisterPropertyInteger("SceneS1SingleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS1DoubleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS1HoldTarget",0);
		$this->RegisterPropertyInteger("SceneS1ReleaseTarget",0);
		$this->RegisterPropertyInteger("SceneS2SingleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS2DoubleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS2TrippleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS2HoldTarget",0);
		$this->RegisterPropertyInteger("SceneS2ReleaseTarget",0);
		
		$this->RegisterPropertyInteger("SceneS1SingleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS1DoubleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS1HoldDimValue",100);
		$this->RegisterPropertyInteger("SceneS1ReleaseDimValue",100);
		$this->RegisterPropertyInteger("SceneS2SingleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS2DoubleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS2TrippleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS2HoldDimValue",100);
		$this->RegisterPropertyInteger("SceneS2ReleaseDimValue",100);
		
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
				),
				Array(
					"type" => "Select",
					"name" => "SceneS1SingleClickAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS1SingleClickTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS1SingleClickDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
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
				),
				Array(
					"type" => "Select",
					"name" => "SceneS1DoubleClickAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS1DoubleClickTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS1DoubleClickDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
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
