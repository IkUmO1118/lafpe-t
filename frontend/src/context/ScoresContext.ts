import { createContext } from "react";
import { NestedOption, ScoresState } from "../types/diagnosis";

export type ScoresContextValue = {
  scores: ScoresState;
  addCheckboxScore: (question: string, score: number[]) => void;
  addRadioScore: (question: string, score: number) => void;
  addNestedRadioScore: (
    question: string,
    score: { [key: string]: NestedOption },
  ) => void;
  deleteScore: (question: string) => void;
};

// Context オブジェクトのみをエクスポート
export const ScoresContext = createContext<ScoresContextValue | null>(null);
