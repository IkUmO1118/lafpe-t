import { createContext, ReactNode, useContext, useReducer } from "react";

export type CheckboxScore = number[];

export type RadioScore = number;

type NestedOption = {
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

type QuestionKeys =
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

type ScoresState = {
  [K in QuestionKeys]: K extends "Q3"
    ? NestedRadioScore
    : K extends "Q4" | "Q5" | "Q6"
      ? RadioScore
      : CheckboxScore;
};

type ScoresContextValue = {
  scores: ScoresState;
  addCheckBoxScore: (question: string, score: number[]) => void;
  addRadioScore: (question: string, score: number) => void;
  addNestedRadioScore: (
    question: string,
    score: { [key: string]: NestedOption },
  ) => void;
  deleteScore: (question: string) => void;
};

const ScoresContext = createContext<ScoresContextValue | null>(null);

type Action =
  | {
      type: "ADD_CHECKBOX_SCORE";
      payload: { question: string; score: number[] };
    }
  | { type: "ADD_RADIO_SCORE"; payload: { question: string; score: number } }
  | {
      type: "ADD_NESTED_SCORE";
      payload: { question: string; score: { [key: string]: NestedOption } };
    }
  | { type: "DELETE_SCORE"; payload: string };

// 4. Reducer を修正
function scoresReducer(state: ScoresState, action: Action): ScoresState {
  switch (action.type) {
    case "ADD_CHECKBOX_SCORE":
      return {
        ...state,
        [action.payload.question]: action.payload.score,
      };

    case "ADD_RADIO_SCORE":
      return {
        ...state,
        [action.payload.question]: action.payload.score,
      };

    case "ADD_NESTED_SCORE":
      return {
        ...state,
        [action.payload.question]: action.payload.score,
      };

    case "DELETE_SCORE":
      return {
        ...state,
        [action.payload]:
          action.payload === "Q3"
            ? {}
            : action.payload.match(/Q[4-6]/)
              ? 0
              : [],
      };

    default:
      return state;
  }
}

const initialState: ScoresState = {
  Q1: [],
  Q2: [],
  Q3: {},
  Q4: 0,
  Q5: 0,
  Q6: 0,
  Q7: [],
  Q8: [],
  Q9: [],
  Q10: [],
  Q11: [],
  Q12: [],
  Q13: [],
};

type ScoresContextProviderProps = {
  children: ReactNode;
};

function ScoresContextProvider({ children }: ScoresContextProviderProps) {
  const [scores, dispatch] = useReducer(scoresReducer, initialState);

  const ctx: ScoresContextValue = {
    scores,
    addCheckBoxScore(question, score) {
      dispatch({
        type: "ADD_CHECKBOX_SCORE",
        payload: { question, score },
      });
    },
    addRadioScore(question, score) {
      dispatch({
        type: "ADD_RADIO_SCORE",
        payload: { question, score },
      });
    },
    addNestedRadioScore(question, score) {
      dispatch({
        type: "ADD_NESTED_SCORE",
        payload: { question, score },
      });
    },
    deleteScore(question) {
      dispatch({
        type: "DELETE_SCORE",
        payload: question,
      });
    },
  };

  return (
    <ScoresContext.Provider value={ctx}>{children}</ScoresContext.Provider>
  );
}

export function useScoresContext() {
  const scoresCts = useContext(ScoresContext);
  if (scoresCts === null) {
    throw new Error("ScoresContext is null");
  }

  return scoresCts;
}

export default ScoresContextProvider;
