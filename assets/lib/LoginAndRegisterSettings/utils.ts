type ReturnFields = {
  type: "TEXT" | "CHECKBOX";
  label: string;
  value: string | boolean;
  key: string;
}[];

export function getEmailFieldsFor(
  id: string,
  settings: Record<string, any>
): ReturnFields {
  const field = settings.fields.find((field) => field.id == id);
  if (!field) throw Error("No Field was found for id: " + id);

  return [
    {
      type: "TEXT",
      label: "Label",
      value: field.label,
      key: "label",
    },
		{
			type:"TEXT",
			label:"Placeholder",
			value:field.placeholder,
			key:"placeholder",
		},
  ];
}

export function getNameFieldsFor(
  id: string,
  settings: Record<string, any>
): ReturnFields {
  const field = settings.fields.find((field) => field.id == id);
  if (!field) throw Error("No Field was found for id: " + id);

  return [
    {
      type: "TEXT",
      label: "Label",
      value: field.label,
      key: "label",
    },
		{
			type:"TEXT",
			label:"Placeholder",
			value:field.placeholder,
			key:"placeholder",
		},
    {
      type: "CHECKBOX",
      label: "Is Required",
      value: field.isRequired,
      key: "isRequired",
    },
  ];
}

export function getTextFieldsFor(
  id: string,
  settings: Record<string, any>
): ReturnFields {
  const field = settings.fields.find((field) => field.id == id);
  if (!field) throw Error("No Field was found for id: " + id);

  return [
    {
      type: "TEXT",
      label: "Label",
      value: field.label,
      key: "label",
    },
    {
      type: "TEXT",
      label: "Name",
      value: field.name,
      key: "name",
    },
    {
      type: "CHECKBOX",
      label: "Is Required",
      value: field.isRequired,
      key: "isRequired",
    },
  ];
}

export function getCheckboxFieldsFor(
  id: string,
  settings: Record<string, any>
): ReturnFields {
  const field = settings.fields.find((field) => field.id == id);
  if (!field) throw Error("No Field was found for id: " + id);

  return [
    {
      type: "TEXT",
      label: "Label",
      value: field.label,
      key: "label",
    },
    {
      type: "TEXT",
      label: "Name",
      value: field.name,
      key: "name",
    },
  ];
}

export function fieldKinds(
  isPrimary: boolean
): { kind: "NAME" | "TEXT" | "CHECKBOX"; onlyOne: boolean }[] {
  const kinds: { kind: "NAME" | "TEXT" | "CHECKBOX"; onlyOne: boolean }[] = [
    { kind: "NAME", onlyOne: true },
  ];
  if (!isPrimary) {
    kinds.push(
      { kind: "TEXT", onlyOne: false },
      { kind: "CHECKBOX", onlyOne: false }
    );
  }

  return kinds;
}

export function genId(): string {
  // Public Domain/MIT
  var d = new Date().getTime(); //Timestamp
  var d2 =
    (typeof performance !== "undefined" &&
      performance.now &&
      performance.now() * 1000) ||
    0; //Time in microseconds since page-load or 0 if unsupported
  return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (c) {
    var r = Math.random() * 16; //random number between 0 and 16
    if (d > 0) {
      //Use timestamp until depleted
      r = (d + r) % 16 | 0;
      d = Math.floor(d / 16);
    } else {
      //Use microseconds since page-load if supported
      r = (d2 + r) % 16 | 0;
      d2 = Math.floor(d2 / 16);
    }
    return (c === "x" ? r : (r & 0x3) | 0x8).toString(16);
  });
}
