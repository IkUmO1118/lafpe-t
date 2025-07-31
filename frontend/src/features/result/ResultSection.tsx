import { useEffect, useRef, useState } from "react";
import { useScoresContext } from "../../hooks/useScoresContext";
import { useGetSession as getSession } from "../../hooks/useSession";
import ResultHeader from "./ResultHeader";
import ResultContent from "./ResultContent";
import ResultNotData from "./ResultNotData";
import ResultLoading from "./ResultLoading";

function ResultSection() {
  const { addAllScores } = useScoresContext();
  const [refreshKey, setRefreshKey] = useState(0);
  const [isLoading, setIsLoading] = useState(true);

  const [kartesData, setKartesData] = useState(null);
  const [answersData, setAnswersData] = useState(null);

  const contentRef = useRef<HTMLDivElement>(null);
  const headerRef = useRef<HTMLDivElement>(null);

  const scrollToHeader = () => {
    headerRef.current?.scrollIntoView({
      behavior: "smooth",
      block: "start",
    });
  };

  // Get fresh data from session
  useEffect(() => {
    setIsLoading(true);
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
      setIsLoading(false);
    } catch (error) {
      setIsLoading(false);
      console.error("Error parsing session data:", error);
    }
    // eslint-disable-next-line react-hooks/exhaustive-deps
  }, [refreshKey]);

  // Function to force refresh data
  const refreshData = () => {
    scrollToHeader();
    setRefreshKey((prev) => prev + 1);
  };

  if (isLoading) {
    return <ResultLoading />;
  }

  if (kartesData === null || answersData === null) {
    return <ResultNotData />;
  }

  return (
    <section className="flex w-full flex-col">
      <ResultHeader
        answersData={answersData}
        kartesData={kartesData}
        ref={headerRef}
      />
      <ResultContent onDataUpdated={refreshData} ref={contentRef} />
    </section>
  );
}

export default ResultSection;
