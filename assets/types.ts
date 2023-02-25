export type FormSettingsType = {
	headingText: string;
	descriptionText: string;
	fields: FieldType[];
	altFormLink: {
		show: false;
		text: string;
	};
	submit: {
		text: string;
	};
	action: FormActionUnion;
};
export type EditorStatesUnion = "EDIT_TEXT"
    | "DEFAULT"
    | "EDIT_EMAIL"
    | "EDIT_NAME"
    | "EDIT_CHECKBOX"
    | "EDIT_HEADING"
    | "EDIT_BUTTON"
    | "EDIT_DESCRIPTION"
		| "EDIT_LINK"
export type FormActionUnion =  "LOGIN"| "REGISTER";

export type FieldType = {
	type: FieldTypeTypeUnion;
	id: string;
	name: string;
	label: string;
	isRequired?:boolean;
};


//I THINK I SHOULD JUST PICK ONE BUT NOT SURE WHICH 
//TRYING BOTH UNTIL I KNOW
//
// use when function params or if statements
export enum FieldTypeTypeEnum {
	EMAIL = "EMAIL",
	CHECKBOX = "CHECKBOX",
	TEXT = "TEXT",
	NAME = "NAME",
}
//USE in Switch Statements or if order needs to be dependable in loops
export type FieldTypeTypeUnion = `${FieldTypeTypeEnum}`
export type AddableFieldTypeUnion = Extract<FieldTypeTypeUnion,"TEXT"| "NAME"| "CHECKBOX">
