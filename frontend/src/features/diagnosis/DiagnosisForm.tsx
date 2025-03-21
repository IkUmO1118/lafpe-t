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
        onClick={(e) => {
          handleSubmit(e);

          if (index < 12) {
            setIndex(index + 1);
          }
        }}
        type="submit"
      >
        次の設問へ&nbsp;&nbsp;&rarr;
      </Button>
    </div>
  );
}

export default DiagnosisForm;
