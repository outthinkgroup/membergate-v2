export const mockFormSettings = {
  PrimaryForm: {
    headingText: "This Content is for Subscribers only",
    descriptionText:
      "Please fill in the form below to get access to this content.",
    fields: [
      {
        type: "NAME",
        id: "wasdf23",
        label: "Name",
        name: "name",
        isRequired: true,
      },
      {
        type: "EMAIL",
        id: "asdfase32",
        name: "email",
        label: "Email",
      },
    ],
    SecondaryFormLink: {
      show: true,
      text: "Not a member yet?",
    },
    submit: {
      text: "Login",
    },
    action: "LOGIN",
  },
  SecondaryForm: {
    isEnabled: true,
    headingText: "Register to get access to VIP Content",
    descriptionText:
      "Please fill in the form below to get access to this content.",
    fields: [
      {
        type: "EMAIL",
        name: "email",
        id: "axca3",
        label: "Email",
      },
      {
        type: "NAME",
        id: "23aass3",
        label: "Name",
        name: "name",
        isRequired: true,
      },
      {
        type: "CHECKBOX",
        id: "a233aaa",
        label: "Subscribe to daily newsletter",
        name: "daily_newsletter",
      },
      {
        type: "TEXT",
        id: "oppase3",
        label: "Some text field",
        name: "MERGE_FIELD",
        isRequired: false,
      },
    ],
    primaryFormLink: {
      show: true,
      text: "Already a member?",
    },
    submit: {
      text: "Register",
    },
    action: "REGISTER",
  },
};
