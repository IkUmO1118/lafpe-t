import { createContext } from "react";
import {
  CheckboxScore,
  NestedOption,
  RadioScore,
  ScoresState,
} from "../types/diagnosis";

export type ScoresContextValue = {
  scores: ScoresState;
  addAllScores: (scoresData: ScoresState) => void;
  addCheckboxScore: (question: string, score: CheckboxScore) => void;
  addRadioScore: (question: string, score: RadioScore) => void;
  addNestedRadioScore: (
    question: string,
    score: { [key: string]: NestedOption },
  ) => void;
  deleteScore: (question: string) => void;
  resetScores: () => void;
};

// Context オブジェクトのみをエクスポート
export const ScoresContext = createContext<ScoresContextValue | null>(null);
