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
    const currentScore = scores[questionNumber as keyof typeof scores];
    // 0の場合でも正しく評価するために、厳密に条件を変更
    if (currentScore !== undefined && currentScore !== null) {
      setSelectedValue(currentScore);
    } else {
      setSelectedValue(null);
    }

    return () => {
      setSelectedValue(null);
    };
  }, [questionNumber, scores]);

  async function handleSubmit(e: FormEvent): Promise<void> {
    e.preventDefault();

    if (selectedValue !== null) {
      if (questionNumber === "Q3") {
        addNestedRadioScore(questionNumber, selectedValue as NestedRadioScore);
      } else if (["Q4", "Q5", "Q6"].includes(questionNumber)) {
        addRadioScore(questionNumber, selectedValue as RadioScore);
      } else {
        addCheckboxScore(questionNumber, selectedValue as CheckboxScore);
      }

      // スコア更新が完了するのを待つために、次のレンダリングサイクルを待つ
      return new Promise((resolve) => setTimeout(resolve, 0));
    }
    return Promise.resolve();
  }

  return {
    selectedValue,
    setSelectedValue,
    handleSubmit,
  };
}

export default useDiagnosisForm;
