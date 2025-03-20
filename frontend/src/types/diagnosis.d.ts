export type CheckboxScore = number[];

export type RadioScore = number | null;

export type NestedOption = {
  isChecked:
    | false
    | {
        isChecked: true;
        per: number;
        times: number;
      };
};

export type NestedRadioScore = {
  [key: string]: NestedOption;
};

export type QuestionKeys =
  | "Q1"
  | "Q2"
  | "Q7"
  | "Q8"
  | "Q9"
  | "Q10"
  | "Q11"
  | "Q12"
  | "Q13"
  | "Q4"
  | "Q5"
  | "Q6"
  | "Q3";

export type ScoresState = {
  [K in QuestionKeys]: K extends "Q3"
    ? NestedRadioScore
    : K extends "Q4" | "Q5" | "Q6"
      ? RadioScore
      : CheckboxScore;
};
