import questionData from "./QuestionConfig.json";

export interface QuestionOption {
  [key: string]:
    | string
    | {
        [key: string]: string;
      };
}

export interface Question {
  title: string;
  option: QuestionOption;
}

export const getQuestion = (index: number): Question => {
  const questionKey = `Q${index + 1}`;
  return questionData[questionKey as keyof typeof questionData];
};
