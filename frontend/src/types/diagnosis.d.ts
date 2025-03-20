export type CheckboxScore = number[];

export type RadioScore = number | null;

export type NestedOption = {
  isChecked: boolean;
  per?: number;
  times?: number;
};

export type NestedRadioScore = {
  [key: string]: NestedOption;
};

export type QuestionKeys =
  | "Q1"
  | "Q2"
  | "Q3"
  | "Q4"
  | "Q5"
  | "Q6"
  | "Q7"
  | "Q8"
  | "Q9"
  | "Q10"
  | "Q11"
  | "Q12"
  | "Q13";

export type ScoresState = {
  Q1: CheckboxScore;
  Q2: CheckboxScore;
  Q3: NestedRadioScore;
  Q4: RadioScore;
  Q5: RadioScore;
  Q6: RadioScore;
  Q7: CheckboxScore;
  Q8: CheckboxScore;
  Q9: CheckboxScore;
  Q10: CheckboxScore;
  Q11: CheckboxScore;
  Q12: CheckboxScore;
  Q13: CheckboxScore;
};
