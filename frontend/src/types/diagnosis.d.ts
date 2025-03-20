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
  | "Q4"
  | "Q5"
  | "Q6"
  | "Q3"
  | "Q7"
  | "Q8"
  | "Q9"
  | "Q10"
  | "Q11"
  | "Q12"
  | "Q13";

export type ScoresState = {
  Q1: number[];
  Q2: number[];
  Q3: {
    オープンラック: {
      isChecked: false;
      per?: number;
      times?: number;
    };
    IVCラック: {
      isChecked: false;
      per?: number;
      times?: number;
    };
    陽圧ラック: {
      isChecked: false;
      per?: number;
      times?: number;
    };
    陰圧ラック: {
      isChecked: false;
      per?: number;
      times?: number;
    };
    一方向気流ラック: {
      isChecked: false;
      per?: number;
      times?: number;
    };
    アイソレータ: {
      isChecked: false;
      per?: number;
      times?: number;
    };
  };
  Q4: number | null;
  Q5: number | null;
  Q6: number | null;
  Q7: number[];
  Q8: number[];
  Q9: number[];
  Q10: number[];
  Q11: number[];
  Q12: number[];
  Q13: number[];
};
