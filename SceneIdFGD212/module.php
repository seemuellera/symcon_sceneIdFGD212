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
			"10" => "S1 toggle switch",
			"11" => "S1 toggle switch",
			"16" => "S1 single click",
			"14" => "S1 double click",
			"12" => "S1 hold",
			"13" => "S1 release",
			"20" => "S2 toggle switch",
			"21" => "S2 toggle switch",
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
			),
			Array(
				"caption" => "Toggle Dim value",
				"value" => "DimToggle"
			),
			Array(
				"caption" => "Change to a specifc Color",
				"value" => "ChangeToColor"
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
		$this->RegisterPropertyBoolean("SceneS1ToggleSwitchEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1SingleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1DoubleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1HoldEnabled",false);
		$this->RegisterPropertyBoolean("SceneS1ReleaseEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2ToggleSwitchEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2SingleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2DoubleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2TrippleClickEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2HoldEnabled",false);
		$this->RegisterPropertyBoolean("SceneS2ReleaseEnabled",false);
		
		$this->RegisterPropertyString("SceneS1ToggleSwitchAction","Toggle");
		$this->RegisterPropertyString("SceneS1SingleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS1DoubleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS1HoldAction","Toggle");
		$this->RegisterPropertyString("SceneS1ReleaseAction","Toggle");
		$this->RegisterPropertyString("SceneS2ToggleSwitchAction","Toggle");
		$this->RegisterPropertyString("SceneS2SingleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS2DoubleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS2TrippleClickAction","Toggle");
		$this->RegisterPropertyString("SceneS2HoldAction","Toggle");
		$this->RegisterPropertyString("SceneS2ReleaseAction","Toggle");
		
		$this->RegisterPropertyInteger("SceneS1ToggleSwitchTarget",0);
		$this->RegisterPropertyInteger("SceneS1SingleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS1DoubleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS1HoldTarget",0);
		$this->RegisterPropertyInteger("SceneS1ReleaseTarget",0);
		$this->RegisterPropertyInteger("SceneS2ToggleSwitchTarget",0);
		$this->RegisterPropertyInteger("SceneS2SingleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS2DoubleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS2TrippleClickTarget",0);
		$this->RegisterPropertyInteger("SceneS2HoldTarget",0);
		$this->RegisterPropertyInteger("SceneS2ReleaseTarget",0);
		
		$this->RegisterPropertyInteger("SceneS1ToggleSwitchDimValue",100);
		$this->RegisterPropertyInteger("SceneS1SingleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS1DoubleClickDimValue",100);
		$this->RegisterPropertyInteger("SceneS1HoldDimValue",100);
		$this->RegisterPropertyInteger("SceneS1ReleaseDimValue",100);
		$this->RegisterPropertyInteger("SceneS2ToggleSwitchDimValue",100);
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
			"caption" => $this->SceneNames[10],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS1ToggleSwitchEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS1ToggleSwitchAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS1ToggleSwitchTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS1ToggleSwitchDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
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
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[12],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS1HoldEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS1HoldAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS1HoldTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS1HoldDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[13],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS1ReleaseEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS1ReleaseAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS1ReleaseTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS1ReleaseDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[20],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS2ToggleSwitchEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS2ToggleSwitchAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS2ToggleSwitchTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS2ToggleSwitchDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[26],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS2SingleClickEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS2SingleClickAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS2SingleClickTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS2SingleClickDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[24],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS2DoubleClickEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS2DoubleClickAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS2DoubleClickTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS2DoubleClickDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[25],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS2TrippleClickEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS2TrippleClickAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS2TrippleClickTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS2TrippleClickDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[22],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS2HoldEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS2HoldAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS2HoldTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS2HoldDimValue",
					"caption" => "Target Dimming Value (only applicable for Dim to Value mode)"
				)
			)
		);
		
		$form['elements'][] = Array(
			"type" => "ExpansionPanel", 
			"caption" => $this->SceneNames[23],
			"items" => Array(
				Array(
					"type" => "CheckBox",
					"name" => "SceneS2ReleaseEnabled",
					"caption" => "Enable Scene"
				),
				Array(
					"type" => "Select",
					"name" => "SceneS2ReleaseAction",
					"caption" => "Action",
					"options" => $this->SceneActions
				),
				Array(
					"type" => "SelectVariable",
					"name" => "SceneS2ReleaseTarget",
					"caption" => "Target Variable"
				),
				Array(
					"type" => "NumberSpinner",
					"name" => "SceneS2ReleaseDimValue",
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
		
		IPS_LogMessage($this->ReadPropertyString('Sender') . " - " . $this->InstanceID, $messageComplete);
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
		
		if ($Data[3] == $Data[4]) {
			
			$this->LogMessage("Duplicate Event. Ignoring it", "DEBUG");
			return;
		}
		
		$sceneId = $Data[0];
		
		// Exit the function if the scene ID is disabled
		switch ($sceneId) {
		
			case "10":
				if (! $this->ReadPropertyBoolean("SceneS1ToggleSwitchEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS1ToggleSwitchTarget"), $this->ReadPropertyString("SceneS1ToggleSwitchAction"), $this->ReadPropertyInteger("SceneS1ToggleSwitchDimValue"));
				break;
			case "11":
				if (! $this->ReadPropertyBoolean("SceneS1ToggleSwitchEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS1ToggleSwitchTarget"), $this->ReadPropertyString("SceneS1ToggleSwitchAction"), $this->ReadPropertyInteger("SceneS1ToggleSwitchDimValue"));
				break;
			case "16":
				if(! $this->ReadPropertyBoolean("SceneS1SingleClickEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS1SingleClickTarget"), $this->ReadPropertyString("SceneS1SingleClickAction"), $this->ReadPropertyInteger("SceneS1SingleClickDimValue"));
				break;
			case "14":
				if(! $this->ReadPropertyBoolean("SceneS1DoubleClickEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS1DoubleClickTarget"), $this->ReadPropertyString("SceneS1DoubleClickAction"), $this->ReadPropertyInteger("SceneS1DoubleClickDimValue"));
				break;
			case "12":
				if(! $this->ReadPropertyBoolean("SceneS1HoldEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS1HoldTarget"), $this->ReadPropertyString("SceneS1HoldAction"), $this->ReadPropertyInteger("SceneS1HoldDimValue"));
				break;
			case "13":
				if(! $this->ReadPropertyBoolean("SceneS1HoldEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS1ReleaseTarget"), $this->ReadPropertyString("SceneS1ReleaseAction"), $this->ReadPropertyInteger("SceneS1ReleaseDimValue"));
				break;
			case "20":
				if (! $this->ReadPropertyBoolean("SceneS2ToggleSwitchEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2ToggleSwitchTarget"), $this->ReadPropertyString("SceneS2ToggleSwitchAction"), $this->ReadPropertyInteger("SceneS2ToggleSwitchDimValue"));
				break;
			case "21":
				if (! $this->ReadPropertyBoolean("SceneS2ToggleSwitchEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2ToggleSwitchTarget"), $this->ReadPropertyString("SceneS2ToggleSwitchAction"), $this->ReadPropertyInteger("SceneS2ToggleSwitchDimValue"));
				break;
			case "26":
				if(! $this->ReadPropertyBoolean("SceneS2SingleClickEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2SingleClickTarget"), $this->ReadPropertyString("SceneS2SingleClickAction"), $this->ReadPropertyInteger("SceneS2SingleClickDimValue"));
				break;
			case "24":
				if(! $this->ReadPropertyBoolean("SceneS2DoubleClickEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2DoubleClickTarget"), $this->ReadPropertyString("SceneS2DoubleClickAction"), $this->ReadPropertyInteger("SceneS2DoubleClickDimValue"));
				break;
			case "25":
				if(! $this->ReadPropertyBoolean("SceneS2TrippleClickEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2TrippleClickTarget"), $this->ReadPropertyString("SceneS2TrippleClickAction"), $this->ReadPropertyInteger("SceneS2TrippleClickDimValue"));
				break;
			case "22":
				if(! $this->ReadPropertyBoolean("SceneS2HoldEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2HoldTarget"), $this->ReadPropertyString("SceneS2HoldAction"), $this->ReadPropertyInteger("SceneS2HoldDimValue"));
				break;
			case "23":
				if(! $this->ReadPropertyBoolean("SceneS2HoldEnabled") ) {
					return;
				}
				$this->DeviceHandler($this->ReadPropertyInteger("SceneS2ReleaseTarget"), $this->ReadPropertyString("SceneS2ReleaseAction"), $this->ReadPropertyInteger("SceneS2ReleaseDimValue"));
				break;
			default:
				throw new Exception("Invalid Scene ID" . $sceneId);
		}
		
		SetValue($this->GetIDForIdent("LastTrigger"), time());
		SetValue($this->GetIDForIdent("LastAction"), $this->SceneNames[$sceneId]);
	}

	protected function DeviceHandler($targetId, $action, $specificValue = false) {
		
		switch ($action) {
			
			case "Toggle":
				$this->ToggleDevice($targetId);
				return;
			case "SwitchOn":
				$this->SwitchDeviceOn($targetId);
				return;
			case "SwitchOff":
				$this->SwitchDeviceOff($targetId);
				return;
			case "DimToValue":
				$this->DimDeviceToValue($targetId, $specificValue);
				return;
			case "DimToggle":
				$this->DimDeviceToggle($targetId, $specificValue);
				return;
			case "ChangeToColor":
				$this->ChangeDeviceToColor($targetId, $specificValue);
				return;
			default:
				throw new Exception("Action not yet implemented");
		}
	}
	
	protected function ToggleDevice($targetId) {
		
		if (GetValue($targetId) ) {
			
			RequestAction($targetId, false);
		}
		else {
			
			RequestAction($targetId, true);
		}
	}
	
	protected function SwitchDeviceOn($targetId) {
			
		RequestAction($targetId, true);
	}
	
	protected function SwitchDeviceOff($targetId) {
			
		RequestAction($targetId, false);
	}
	
	protected function DimDeviceToValue($targetId, $value) {
			
		RequestAction($targetId, $value);
	}
	
	protected function DimDeviceToggle($targetId, $value) {
			
		if (GetValue($targetId) == 0) {
			
			RequestAction($targetId, $value);
		}
		else {
			
			RequestAction($targetId, 0);
		}
	}
	
	protected function ChangeDeviceToColor($targetId, $value) {
			
		RequestAction($targetId, $value);
	}
}
