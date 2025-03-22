import { FormEvent } from "react";
import { Button } from "../../components/Button";
import { getQuestion } from "../../config/QuestionConfig";
import QuestionFactory from "../../factory/QuestionFactory";
import useDiagnosisForm from "./useDiagnosisForm";
import { useCreateKarte } from "../karte/useCreateKarte";
import { useScoresContext } from "../../hooks/useScoresContext";
import { CheckboxScore } from "../../types/diagnosis";
import SpinnerMini from "../../components/SpinnerMini";

interface DiagnosisFormProps {
  index: number;
  setIndex: (index: number) => void;
}

function DiagnosisForm({ index, setIndex }: DiagnosisFormProps) {
  const question = getQuestion(index);
  const questionNumber = `Q${index + 1}`;
  const { selectedValue, setSelectedValue, handleSubmit } =
    useDiagnosisForm(questionNumber);
  const { scores } = useScoresContext();
  const { isCreating, createKarte } = useCreateKarte();

  const handleButtonClick = async (e: FormEvent) => {
    e.preventDefault();

    if (questionNumber === "Q13") {
      if (selectedValue !== null) {
        await handleSubmit(e);

        // 型を明示的に指定して新しいスコアオブジェクトを作成
        const updatedScores = {
          ...scores,
          [questionNumber]: selectedValue as CheckboxScore,
        };

        // 新しいスコアオブジェクトを使用して関数を呼び出す
        createKarte(updatedScores);
      }
      return;
    }

    handleSubmit(e);
    setIndex(index + 1);
  };

  return (
    <div className="flex flex-col gap-3">
      <QuestionFactory
        questionNumber={questionNumber}
        questionTitle={question.title}
        options={question.option}
        value={selectedValue ?? []}
        onChange={setSelectedValue}
        perOptions={question.per}
        timesOptions={question.times}
        index={index}
      />

      <Button
        className="self-center py-3 font-medium"
        onClick={(e) => handleButtonClick(e)}
        type="submit"
      >
        {isCreating && questionNumber === "Q13" ? (
          <SpinnerMini message="診断中..." />
        ) : questionNumber === "Q13" ? (
          "完了する"
        ) : (
          "次の設問へ　→"
        )}
      </Button>
    </div>
  );
}

export default DiagnosisForm;
