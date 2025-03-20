import { FormEvent, useEffect, useState } from "react";
import {
  CheckboxScore,
  NestedRadioScore,
  RadioScore,
} from "../../types/diagnosis";
import { useScoresContext } from "../../hooks/useScoresContext";

type Score = CheckboxScore | RadioScore | NestedRadioScore;

function useDiagnosisForm(questionNumber: string) {
  const [selectedValue, setSelectedValue] = useState<Score | null>(null);
  const { scores, addCheckboxScore, addRadioScore, addNestedRadioScore } =
    useScoresContext();

  useEffect(() => {
    console.log("Current scores:", {
      allScores: scores,
      currentQuestion: questionNumber,
    });

    const currentScore = scores[questionNumber as keyof typeof scores];
    if (currentScore) {
      setSelectedValue(currentScore);
    } else {
      setSelectedValue(null);
    }

    return () => {
      setSelectedValue(null);
    };
  }, [questionNumber, scores]);

  function handleSubmit(e: FormEvent) {
    e.preventDefault();

    if (selectedValue !== null) {
      if (questionNumber === "Q3") {
        addNestedRadioScore(questionNumber, selectedValue as NestedRadioScore);
      } else if (["Q4", "Q5", "Q6"].includes(questionNumber)) {
        addRadioScore(questionNumber, selectedValue as RadioScore);
      } else {
        addCheckboxScore(questionNumber, selectedValue as CheckboxScore);
      }
    }
  }

  return {
    selectedValue,
    setSelectedValue,
    handleSubmit,
  };
}

export default useDiagnosisForm;
