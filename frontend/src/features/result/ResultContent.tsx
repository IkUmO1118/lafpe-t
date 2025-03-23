import { useCallback, useState } from "react";
import { getQuestion } from "../../config/QuestionConfig";
import QuestionFactory from "../../factory/QuestionFactory";
import { useScoresContext } from "../../hooks/useScoresContext";
import {
  CheckboxScore,
  NestedRadioScore,
  RadioScore,
} from "../../types/diagnosis";
import { useUpdateKarte } from "../karte/useUpdatekarte";
import { useSetSession as setSession } from "../../hooks/useSession";
import { useOutsideClick } from "../../hooks/useOutsideClick";

// Resultからの通信のためのインターフェース追加
interface ResultContentProps {
  onDataUpdated: () => void;
}

function ResultContent({ onDataUpdated }: ResultContentProps) {
  const [editingQuestion, setEditingQuestion] = useState<string | null>(null);
  const [editedValues, setEditedValues] = useState<
    Record<string, CheckboxScore | RadioScore | NestedRadioScore>
  >({});

  const { scores, addAllScores } = useScoresContext();
  const { isUpdating, updateKarte } = useUpdateKarte();
  const questionIndexes = Array.from({ length: 13 }, (_, i) => i);

  // メモ化したhandleCancelをuseOutsideClickに渡す
  const handleCancel = useCallback(() => {
    setEditingQuestion(null);
  }, []);

  // 編集中の質問の外側をクリックしたときに編集状態を解除するためのref
  const outsideClickRef = useOutsideClick<HTMLDivElement>(handleCancel);

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

    updateKarte(updatedScores, {
      onSuccess: () => {
        setSession({
          key: "answer",
          value: JSON.stringify(updatedScores),
        });

        // 親コンポーネントにデータ更新を通知して再描画を促す
        onDataUpdated();
        setEditingQuestion(null);
      },
    });
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
              ref={isEditing ? outsideClickRef : null}
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
                isUpdating={isUpdating}
              />
            </div>
          );
        })}
      </div>
    </div>
  );
}

export default ResultContent;
