import ResultContent from "../features/result/ResultContent";
import ResultHeader from "../features/result/ResultHeader";

function Result() {
  const questionAnswers = {
    Q1: [1],

    Q2: [0, 1],

    Q3: {
      openRack: {
        isChecked: false,
      },
      IVCRack: {
        isChecked: false,
      },
      positiveRack: {
        isChecked: true,
        per: 0,
        times: 3,
      },
      negativeRack: {
        isChecked: false,
      },
      oneWayAirflowRack: {
        isChecked: true,
        per: 4,
        times: 2,
      },
      isolator: {
        isChecked: false,
      },
    },
    Q4: 1,

    Q5: 0,

    Q6: 2,

    Q7: [1],

    Q8: [0],

    Q9: [0, 1],

    Q10: [3],

    Q11: [0, 1],

    Q12: [1, 2, 4, 8, 11, 12],

    Q13: [0],
  };

  return (
    <section className="flex w-full flex-col">
      <ResultHeader questionAnswers={questionAnswers} />
      <ResultContent />
    </section>
  );
}

export default Result;
