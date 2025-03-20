import { useContext } from "react";
import { ScoresContext, ScoresContextValue } from "../context/ScoresContext";

export function useScoresContext(): ScoresContextValue {
  const scoresCts = useContext(ScoresContext);
  if (scoresCts === null) {
    throw new Error("ScoresContext is null");
  }
  return scoresCts;
}
