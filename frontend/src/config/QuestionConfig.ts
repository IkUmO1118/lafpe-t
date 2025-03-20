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
  option: { [key: string]: string };
  per?: { [key: string]: string };
  times?: { [key: string]: string };
}

export const getQuestion = (index: number): Question => {
  const questionKey = `Q${index + 1}`;
  return questionData[questionKey as keyof typeof questionData];
};
