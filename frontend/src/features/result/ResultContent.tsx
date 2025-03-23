import { useState } from "react";
import { getQuestion } from "../../config/QuestionConfig";
import QuestionFactory from "../../factory/QuestionFactory";
import { useScoresContext } from "../../hooks/useScoresContext";
import {
  CheckboxScore,
  NestedRadioScore,
  RadioScore,
} from "../../types/diagnosis";

function ResultContent() {
  const { scores, addAllScores } = useScoresContext();
  const [editingQuestion, setEditingQuestion] = useState<string | null>(null);
  const [editedValues, setEditedValues] = useState<
    Record<string, CheckboxScore | RadioScore | NestedRadioScore>
  >({});

  const questionIndexes = Array.from({ length: 13 }, (_, i) => i);

  const handleEdit = (questionNumber: string) => {
    setEditingQuestion(questionNumber);
    setEditedValues({
      ...editedValues,
      [questionNumber]: scores[questionNumber as keyof typeof scores],
    });
  };

  const handleUpdate = (questionNumber: string) => {
    const updatedScores = {
      ...scores,
      [questionNumber]: editedValues[questionNumber],
    };

    addAllScores(updatedScores);

    setEditingQuestion(null);
  };

  const handleCancel = () => {
    setEditingQuestion(null);
  };

  const handleChange = (
    questionNumber: string,
    newValue: CheckboxScore | RadioScore | NestedRadioScore,
  ) => {
    setEditedValues({
      ...editedValues,
      [questionNumber]: newValue,
    });
  };

  return (
    <div className="flex w-full flex-col items-center gap-12 bg-neutral-100 px-56 py-14">
      <h2 className="text-4xl font-black text-neutral-900">回答内容</h2>
      <div className="flex w-full flex-col">
        {questionIndexes.map((index) => {
          const question = getQuestion(index);
          const questionNumber = `Q${index + 1}`;
          const isEditing = editingQuestion === questionNumber;
          const value = isEditing
            ? editedValues[questionNumber]
            : scores[questionNumber as keyof typeof scores] || [];

          return (
            <div
              key={questionNumber}
              className="flex w-full flex-col rounded-lg"
            >
              <QuestionFactory
                questionNumber={questionNumber}
                questionTitle={question.title}
                options={question.option}
                value={value}
                onChange={(newValue) => handleChange(questionNumber, newValue)}
                perOptions={question.per}
                timesOptions={question.times}
                index={index}
                readOnly={!isEditing}
                using="result"
                onEdit={() => handleEdit(questionNumber)}
                onUpdate={() => handleUpdate(questionNumber)}
                onCancel={handleCancel}
              />
            </div>
          );
        })}
      </div>
    </div>
  );
}

export default ResultContent;
