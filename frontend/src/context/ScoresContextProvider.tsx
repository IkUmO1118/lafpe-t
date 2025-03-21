import { ReactNode, useReducer } from "react";
import { ScoresContext, ScoresContextValue } from "./ScoresContext";
import {
  CheckboxScore,
  NestedOption,
  RadioScore,
  ScoresState,
} from "../types/diagnosis";

type Action =
  | {
      type: "ADD_CHECKBOX_SCORE";
      payload: { question: string; score: CheckboxScore };
    }
  | {
      type: "ADD_RADIO_SCORE";
      payload: { question: string; score: RadioScore };
    }
  | {
      type: "ADD_NESTED_SCORE";
      payload: { question: string; score: { [key: string]: NestedOption } };
    }
  | { type: "DELETE_SCORE"; payload: string };

function scoresReducer(state: ScoresState, action: Action): ScoresState {
  switch (action.type) {
    case "ADD_CHECKBOX_SCORE":
      return { ...state, [action.payload.question]: action.payload.score };

    case "ADD_RADIO_SCORE":
      return { ...state, [action.payload.question]: action.payload.score };

    case "ADD_NESTED_SCORE":
      return { ...state, [action.payload.question]: action.payload.score };

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
  Q3: {
    openRack: { isChecked: false },
    IVCRack: { isChecked: false },
    positiveRack: { isChecked: false },
    negativeRack: { isChecked: false },
    oneWayAirflowRack: { isChecked: false },
    isolator: { isChecked: false },
  },
  Q4: null,
  Q5: null,
  Q6: null,
  Q7: [],
  Q8: [],
  Q9: [],
  Q10: [],
  Q11: [],
  Q12: [],
  Q13: [],
};

type ScoresContextProviderProps = { children: ReactNode };

function ScoresContextProvider({ children }: ScoresContextProviderProps) {
  const [scores, dispatch] = useReducer(scoresReducer, initialState);

  const ctx: ScoresContextValue = {
    scores,
    addCheckboxScore(question, score) {
      dispatch({ type: "ADD_CHECKBOX_SCORE", payload: { question, score } });
    },
    addRadioScore(question, score) {
      dispatch({ type: "ADD_RADIO_SCORE", payload: { question, score } });
    },
    addNestedRadioScore(question, score) {
      dispatch({ type: "ADD_NESTED_SCORE", payload: { question, score } });
    },
    deleteScore(question) {
      dispatch({ type: "DELETE_SCORE", payload: question });
    },
  };

  return (
    <ScoresContext.Provider value={ctx}>{children}</ScoresContext.Provider>
  );
}

export default ScoresContextProvider;
