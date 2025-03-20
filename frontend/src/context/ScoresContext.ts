import { createContext } from "react";
import {
  CheckboxScore,
  NestedOption,
  RadioScore,
  ScoresState,
} from "../types/diagnosis";

export type ScoresContextValue = {
  scores: ScoresState;
  addCheckboxScore: (question: string, score: CheckboxScore) => void;
  addRadioScore: (question: string, score: RadioScore) => void;
  addNestedRadioScore: (
    question: string,
    score: { [key: string]: NestedOption },
  ) => void;
  deleteScore: (question: string) => void;
};

// Context オブジェクトのみをエクスポート
export const ScoresContext = createContext<ScoresContextValue | null>(null);
