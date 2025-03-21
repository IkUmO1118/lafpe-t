import { FormEvent } from "react";
import { Button } from "../../components/Button";
import { getQuestion } from "../../config/QuestionConfig";
import QuestionFactory from "../../factory/QuestionFactory";
import useDiagnosisForm from "./useDiagnosisForm";

interface DiagnosisFormProps {
  index: number;
  setIndex: (index: number) => void;
}

function DiagnosisForm({ index, setIndex }: DiagnosisFormProps) {
  const question = getQuestion(index);
  const questionNumber = `Q${index + 1}`;
  const { selectedValue, setSelectedValue, handleSubmit } =
    useDiagnosisForm(questionNumber);

  const handleButtonClick = async (e: FormEvent) => {
    e.preventDefault();

    if (questionNumber === "Q13") {
      // This is the final question
      try {
        console.log("success to submit diagnosis!");
        // await submitDiagnosis();
      } catch (error) {
        console.error("Failed to submit diagnosis:", error);
        // Show error message to user
      }
    } else {
      handleSubmit(e);
      setIndex(index + 1);
    }
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
        {questionNumber !== "Q13" ? "次の設問へ　→" : "完了する"}
      </Button>
    </div>
  );
}

export default DiagnosisForm;
