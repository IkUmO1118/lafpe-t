import { useEffect, useState } from "react";
import { useScoresContext } from "../../hooks/useScoresContext";
import { useGetSession as getSession } from "../../hooks/useSession";
import ResultHeader from "./ResultHeader";
import ResultContent from "./ResultContent";
import ResultNotData from "./ResultNotData";

function ResultSection() {
  const { addAllScores } = useScoresContext();
  const [refreshKey, setRefreshKey] = useState(0);

  // Use state to store the parsed data
  const [kartesData, setKartesData] = useState(null);
  const [answersData, setAnswersData] = useState(null);

  // Get fresh data from session
  useEffect(() => {
    try {
      const rawKarteData = getSession("karte");
      const rawAnswerData = getSession("answer");

      if (rawKarteData) {
        const parsedKarteData = JSON.parse(rawKarteData);
        setKartesData(parsedKarteData);
      }

      if (rawAnswerData) {
        const parsedAnswerData = JSON.parse(rawAnswerData);
        setAnswersData(parsedAnswerData);
        addAllScores(parsedAnswerData);
      }
    } catch (error) {
      console.error("Error parsing session data:", error);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [refreshKey]);

  // Function to force refresh data
  const refreshData = () => {
    setRefreshKey((prev) => prev + 1);
  };

  if (kartesData === null || answersData === null) {
    return <ResultNotData />;
  }

  return (
    <section className="flex w-full flex-col">
      <ResultHeader answersData={answersData} kartesData={kartesData} />
      <ResultContent onDataUpdated={refreshData} />
    </section>
  );
}

export default ResultSection;
