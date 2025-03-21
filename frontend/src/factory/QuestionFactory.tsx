import CheckboxQuestion from "../components/CheckboxQuestion";
import NestedRadioQuestion from "../components/NestedRadioQuestion";
import QuestionWrapper from "../components/QuestionWrapper";
import RadioQuestion from "../components/RadioQuestion";
import { getQuestion } from "../config/QuestionConfig";
import {
  CheckboxScore,
  NestedRadioScore,
  RadioScore,
} from "../types/diagnosis";

interface QuestionFactoryProps {
  questionNumber: string;
  questionTitle: string;
  options: Record<string, string | { label: string }>;
  value: CheckboxScore | RadioScore | NestedRadioScore;
  onChange: (newValue: CheckboxScore | RadioScore | NestedRadioScore) => void;
  perOptions?: Record<string, string>;
  timesOptions?: Record<string, string>;
  showNumber?: boolean;
  index?: number;
  readOnly?: boolean;
}

function QuestionFactory({
  questionNumber,
  questionTitle,
  options,
  value,
  onChange,
  perOptions,
  timesOptions,
  showNumber = true,
  index,
  readOnly = false,
}: QuestionFactoryProps) {
  const questionType = getQuestion(parseInt(questionNumber.slice(1)) - 1).type;

  let questionComponent;
  switch (questionType) {
    case "checkbox":
      questionComponent = (
        <CheckboxQuestion
          options={options as Record<string, string>}
          value={value as CheckboxScore}
          onChange={onChange}
          readOnly={readOnly}
        />
      );
      break;
    case "radio":
      questionComponent = (
        <RadioQuestion
          options={options as Record<string, string>}
          value={value as RadioScore}
          onChange={onChange}
          name={questionNumber}
          readOnly={readOnly}
        />
      );
      break;
    case "nestedRadio":
      questionComponent = (
        <NestedRadioQuestion
          options={options}
          value={value as NestedRadioScore}
          onChange={onChange}
          perOptions={perOptions}
          timesOptions={timesOptions}
          readOnly={readOnly}
        />
      );
      break;
    default:
      questionComponent = null;
  }

  return (
    <QuestionWrapper
      title={questionTitle}
      number={index ? index + 1 : parseInt(questionNumber.slice(1))}
      showNumber={showNumber}
    >
      {questionComponent}
    </QuestionWrapper>
  );
}

export default QuestionFactory;
